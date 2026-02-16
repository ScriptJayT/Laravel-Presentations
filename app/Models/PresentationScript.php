<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use TuchSoft\CommonMarkHeadingShifter\HeadingShifterExtension;

class PresentationScript extends Model
{
    use HasFactory;

    public function presentation(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }

    protected function content(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::of($value)->markdown(
                ['heading_shifter' => ['shift_by' => 1]],
                [new HeadingShifterExtension]
            ),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->diffForHumans(),
        );
    }
}
