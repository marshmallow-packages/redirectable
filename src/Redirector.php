<?php

namespace Marshmallow\Redirectable;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\HelperFunctions\Facades\URL;

class Redirector
{
    public function add(Model $model, string $redirect_this, string $to_this): Model
    {
        $this->deleteUnusedRedirects($model, $to_this);
        $this->updateAllTrailingRedirects($model, $to_this);

        $model->redirectable()->create([
            'redirect_this' => $redirect_this,
            'to_this' => $to_this,
        ]);

        return $model;
    }

    /**
     * This method will delete all redirects that are not
     * needed anymore when a new redirect is created. For instance;
     * If we have a redirect from /page-1 to /page-2 and the
     * newly provided slug is /page-1 again, then we don't need that
     * redirect anymore.
     * @license Test
     * @link    Test
     * @return  [type] [description]
     */
    public function deleteUnusedRedirects(Model $model, string $to_this): void
    {
        $redirect_exists = $model->redirectable->where('redirect_this', $to_this)->first();
        if ($redirect_exists) {
            $redirect_exists->delete();
        }
    }

    /**
     * If we have a page resource that has a redirect from
     * /page-1 to /page-2. Now this resource is updated with
     * a slug of /my-new-slug. The result should be this;
     * /page-1 redirect to /my-new-slug
     * /page-2 redirect to /my-new-slug
     * This method will make sure we update all endpoints to the
     * newly created slug.
     * @license Test
     * @link    Test
     * @return  void
     */
    public function updateAllTrailingRedirects(Model $model, string $to_this): void
    {
        $redirects = $model->redirectable;
        foreach ($redirects as $redirect) {
            $redirect->update([
                'to_this' => $to_this,
            ]);
        }
    }


    /**
     * Load all the redirectable routes to our routes so
     * the will in fact do a redirect and are able to
     * be cached.
     * @return  void
     */
    public function routes(): void
    {
        if ($this->shouldLoadRoutes()) {
            $routes = \Route::getRoutes()->getRoutes();
            $route_uris = collect($routes)->map(function ($route) {
                return $route->uri();
            })->unique();

            $redirect_array = [];

            config('redirectable.models.redirect')::cursor()
                ->reject(function ($redirect) use (&$route_uris) {
                    $exists = URL::routeUriExists($redirect->redirect_this, $route_uris);

                    if (!$exists) {
                        $route_uris = $route_uris->add($redirect->redirect_this);
                    }

                    return $exists;
                })->each(function ($redirect) {
                    Route::get($redirect->redirect_this, '\Marshmallow\Redirectable\Http\Controllers\RedirectController');
                });
        }
    }

    protected function shouldLoadRoutes(): bool
    {
        $connection = $this->getDatabaseConnection();
        $schema_builder = Schema::connection($connection);

        if (!$schema_builder->hasTable('pages')) {
            /**
             * Don't load the routes if the pages table
             * doesnt exist. If this is the case, the
             * migrations haven't fully run yet.
             */
            return false;
        }

        return true;
    }

    protected function getDatabaseConnection()
    {
        return config('redirectable.database.connection');
    }
}
