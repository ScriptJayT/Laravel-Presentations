<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Database\Factories\PresentationVisibilityFactory;


class PresentationVisibility extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
    ];
}
