<?php

namespace App\Models;

use App\Traits\CastUpdatedAtAsDiff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use TuchSoft\CommonMarkHeadingShifter\HeadingShifterExtension;

class PresentationScript extends Model
{
    use CastUpdatedAtAsDiff, HasFactory;

    protected $fillable = ['title', 'content'];

    // ## Casting

    // new attributes
    protected $appends = ['renderedContent'];

    protected function getRenderedContentAttribute(): string
    {
        return Str::of($this->content)->markdown(
            [
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
                'heading_shifter' => ['shift_by' => 1],
            ],
            [new HeadingShifterExtension]
        );
    }

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
