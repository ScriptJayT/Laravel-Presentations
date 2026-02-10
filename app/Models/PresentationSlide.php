<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PresentationSlide extends Model
{
    use HasFactory;

    protected $with = ['presentationTheme'];

    public function content(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::of($value)->markdown(),
        );
    }

    public function presentationTheme(): BelongsTo
    {
        return $this->belongsTo(PresentationTheme::class);
    }
}
