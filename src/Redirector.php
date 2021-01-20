<?php

namespace Marshmallow\Redirectable;

use Illuminate\Support\Facades\Route;
use Marshmallow\HelperFunctions\Facades\URL;
use Marshmallow\Redirectable\Models\Redirect;

class Redirector
{
    public function routes()
    {
        $redirect_array = [];
        $redirects = Redirect::get();
        foreach ($redirects as $redirect) {
            if (URL::routeUriExists($redirect->redirect_this)) {
                continue;
            }

            Route::get($redirect->redirect_this, '\Marshmallow\Redirectable\Http\Controllers\RedirectController');
        }
    }
}
