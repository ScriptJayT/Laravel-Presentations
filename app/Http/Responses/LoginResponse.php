<?php

namespace App\Http\Responses;

/**
 * https://laravel.com/docs/12.x/session
 * https://reniki.com/blog/redirect-back-previous-page-after-login-laravel-fortify
 * https://laracasts.com/discuss/channels/laravel/fortify-redirect
 */

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $uri = session()->pull('redirectLinkOnLogin');

        return redirect($uri);
    }
}
