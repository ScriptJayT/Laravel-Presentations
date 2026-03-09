<?php

namespace App\Traits;

use App\Enums\Visibility;
use App\Models\ModelHasUserVisibilityRules;
use App\Models\PresentationVisibility;
use App\Models\User;
use Illuminate\Support\Facades\BackedEnum;
use Illuminate\Support\Facades\Redirect;

trait HasVisibilityRule
{
    protected function isLoggedIn(): bool
    {
        return auth()->check();
    }

    protected function loggedinIsCreator(?User $_creator): bool
    {
        if (! $_creator || ! $_creator->id) {
            return false;
        }
        if (! $this->isLoggedIn()) {
            return false;
        }

        return $_creator->id === auth()->user()->id;
    }

    /**
     * @param  ModelHasUserVisibilityRules  $_model
     *                                               the model to check for if the logged in user has access to;
     * @param  ?string  $_message
     *                             the message to flash on the redirected page;
     *                             this param gets ignored and skipped if $_useAbort is true;
     * @param  ?BackedEnum|string  $_route
     *                                      the location/routename to redirect to;
     *                                      if omited, the location will be: back();
     *                                      this param gets ignored and skipped if $_useAbort is true;
     * @param  ?bool  $_useAbort
     *                            redirect using build in 403 error-page instead of a route;
     *                            params $_route and $_message get ignored if this is set to true;
     */
    protected function returnIfNotAllowed(
        ModelHasUserVisibilityRules $_model,
        ?string $_message = null,
        ?string $_route = null,
        ?bool $_useAbort = false,
    ) {
        if ($this->isAllowedFurter($_model->presentationVisibility, $_model->user)) {
            return false;
        }

        if ($_useAbort) {
            abort(403, "You're not allowed to access this");

            return false;
        }

        return $this->notAllowedRedirect($_message, $_route);
    }

    protected function notAllowedRedirect(?string $_message, ?string $_route)
    {
        if ($_message) {
            session()->flash('error', $_message);
        }

        return $_route
            ? Redirect::route($_route)
            : Redirect::back();
    }

    /**
     * @param  PresentationVisibility  $_visibility  the model only *needs* a title attribute attached
     * @param  ?User  $_user  the model only *needs* an id attribute attached
     */
    protected function isAllowedFurter(PresentationVisibility $_visibility, ?User $_creator): bool
    {
        return match ($_visibility->title) {
            Visibility::PUBLIC->title() => true,
            Visibility::PROTECTED->title() => $this->isLoggedIn(),
            Visibility::PRIVATE->title() => $this->loggedinIsCreator($_creator),
            default => false,
        };
    }
}
