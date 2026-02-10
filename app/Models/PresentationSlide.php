<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use TuchSoft\CommonMarkHeadingShifter\HeadingShifterExtension;

class PresentationSlide extends Model
{
    use HasFactory;

    protected $with = ['presentationTheme'];

    public function content(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::of($value)->markdown(
                ['heading_shifter' => ['shift_by' => 2]],
                [new HeadingShifterExtension]
            ),
        );
    }

    public function presentationTheme(): BelongsTo
    {
        return $this->belongsTo(PresentationTheme::class);
    }
}
