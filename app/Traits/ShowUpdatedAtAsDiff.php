<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

trait ShowUpdatedAtAsDiff
{
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->diffForHumans(),
        );
    }
}
