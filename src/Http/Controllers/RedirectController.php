<?php

namespace Marshmallow\Redirectable\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect as IlluminateRedirect;

class RedirectController extends Controller
{
    public function __invoke(Request $request)
    {
        $uri = $request->path();

        /**
         * Check of we can find a redirect with this path
         */
        $redirect = config('redirectable.models.redirect')::where('redirect_this', $uri)->first();
        if (!$redirect) {
            $this->noRedirectFoundResponse();
        }

        /**
         * Check if we can find a final destination for this path
         */
        $final_route = $redirect->getFinalRedirect();
        if (!$final_route) {
            $this->noRedirectFoundResponse();
        }

        /**
         * Redirect with the correct http code
         */
        return IlluminateRedirect::to($final_route->to_this, $final_route->http_code);
    }

    protected function noRedirectFoundResponse()
    {
        abort(404);
    }
}
