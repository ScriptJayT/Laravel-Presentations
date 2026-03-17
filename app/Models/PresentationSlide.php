<?php

namespace App\Models;

use App\Traits\HasMarkdownRenderableContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresentationSlide extends Model
{
    use HasFactory, HasMarkdownRenderableContent;

    // protected $with = ['presentationTheme'];

    protected $fillable = [
        'title', 'content', 'order',
        'presentation_id',
        'presentation_theme_id',
    ];

    // ## Casting

    protected $appends = [
        'renderedContent', // getter in HasMarkdownRenderableContent trait, setting for that returned in getMdSettings()
    ];

    protected function getMdSettings(): array
    {
        return ['heading_shifter' => ['shift_by' => 2]];
    }

    // ## Relations

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class)
            ->select('id', 'title');
    }

    public function presentationTheme(): BelongsTo
    {
        return $this->belongsTo(PresentationTheme::class)
            ->select('id', 'title');
    }
}
