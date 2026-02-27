<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Requests\SendPasswordResetLinkRequest;

/**
 * fortify routes using PasswordResetLinkController are guarded for guests only; we want it to work in admin too
 */
class AdminPasswordResetController extends Controller
{
    public function store(SendPasswordResetLinkRequest $request)
    {
        if (config('fortify.lowercase_usernames') && $request->has(Fortify::email())) {
            $request->merge([
                Fortify::email() => Str::lower($request->{Fortify::email()}),
            ]);
        }
        // send mail + await status response
        $status = $this->broker()->sendResetLink(
            $request->only(Fortify::email())
        );
        validator(
            ['status' => $status, 'expected' => Password::RESET_LINK_SENT],
            ['status' => 'same:expected']
        )->validate();

        return Redirect::back();
    }

    /**
     * Get the broker to be used during password reset.
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }
}
