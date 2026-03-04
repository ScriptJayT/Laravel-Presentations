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
        if (! $_creator || ! $this->isLoggedIn()) {
            return false;
        }

        return $_creator->id === auth()->user()->id;
    }

    /**
     * @param  ?BackedEnum|string  $_route
     */
    protected function returnIfNotAllowed(ModelHasUserVisibilityRules $_model, ?string $_message, ?string $_route = null)
    {
        if ($this->isAllowedFurter($_model->presentationVisibility, $_model->user)) {
            return false;
        }
        if ($_message) {
            session()->flash('error', $_message);
        }

        return $_route ? Redirect::route($_route) : Redirect::back();
    }

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
