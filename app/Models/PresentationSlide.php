<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentationSlide extends Model
{
    use HasFactory;

    protected $with = ['presentationTheme'];

    public function content(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => trim($value),
        );
    }
}
