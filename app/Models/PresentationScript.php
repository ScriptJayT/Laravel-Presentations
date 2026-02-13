<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PresentationScript extends Model
{
    use HasFactory;

    public function presentation(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }
}
