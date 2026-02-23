<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use TuchSoft\CommonMarkHeadingShifter\HeadingShifterExtension;

class PresentationSlide extends Model
{
    use HasFactory;

    protected $with = ['presentationTheme'];

    protected $fillable = [
        'title', 'content', 'order',
        'presentation_id',
        'presentation_theme_id',
    ];

    // ## Casting
    protected $appends = ['renderedContent'];

    protected function getRenderedContentAttribute(): string
    {
        return Str::of($this->content)->markdown(
            [
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
                'heading_shifter' => ['shift_by' => 2],
            ],
            [new HeadingShifterExtension]
        );
    }

    // ## Relations

    public function presentationTheme(): BelongsTo
    {
        return $this->belongsTo(PresentationTheme::class);
    }
}
