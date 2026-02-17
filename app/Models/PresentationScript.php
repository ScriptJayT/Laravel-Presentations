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

    // ## Casting

    // new attributes
    protected $appends = ['renderedContent'];

    protected function getRenderedContentAttribute(): string
    {
        return Str::of($this->content)->markdown(
            ['heading_shifter' => ['shift_by' => 1]],
            [new HeadingShifterExtension]
        );
    }

    // transform existing attributes
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->diffForHumans(),
        );
    }

    // ## Relations

    public function presentation(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }
}
