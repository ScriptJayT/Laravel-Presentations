<?php

namespace App\Traits;

use App\Enums\Visibility;
use App\Models\PresentationVisibility;
use App\Models\User;

trait HasVisibilityRule
{
    protected function isLoggedIn(): bool
    {
        return auth()->check();
    }

    protected function loggedinIsCreator(User $_creator): bool
    {
        if (! $this->isLoggedIn()) {
            return false;
        }

        return $_creator->id === auth()->user()->id;
    }

    protected function isAllowedFurter(PresentationVisibility $_visibility, User $_creator): bool
    {
        return match ($_visibility->title) {
            Visibility::PUBLIC->title() => true,
            Visibility::PROTECTED->title() => $this->isLoggedIn(),
            Visibility::PRIVATE->title() => $this->loggedinIsCreator($_creator),
            default => false,
        };
    }
}
