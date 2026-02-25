<?php

namespace App\Models;

use App\Traits\CastUpdatedAtAsDiff;
use App\Traits\HasMarkdownRenderableContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PresentationScript extends Model
{
    use CastUpdatedAtAsDiff, HasFactory, HasMarkdownRenderableContent;

    protected $fillable = ['title', 'content'];

    // ## Casting

    // new attributes
    protected $appends = [
        'renderedContent', // getter in HasMarkdownRenderableContent trait w/ default settings
    ];

    // transform existing attributes
    protected function casts(): array
    {
        return [
            'created_at' => "date:m/d/'y",
        ];
    }

    // ## Relations

    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }
}
