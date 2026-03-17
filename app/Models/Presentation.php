<?php

namespace App\Models;

use App\Traits\CastUpdatedAtAsDiff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentation extends Model implements ModelHasUserVisibilityRules
{
    use CastUpdatedAtAsDiff, HasFactory;

    protected $fillable = [
        'title', 'slug',
        'user_id',
        'presentation_visibility_id',
        'presentation_theme_id',
        'presentation_script_id',
    ];

    protected $with = [
        // needs to always eager-load to check access
        'user',
        'presentationVisibility',
    ];

    // ## Casting

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => "date:m/d/'y",
        ];
    }

    // ## Relations

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->select('id', 'name');
    }

    public function presentationScript(): BelongsTo
    {
        return $this->belongsTo(PresentationScript::class)
            ->select('id', 'title');
    }

    public function presentationVisibility(): BelongsTo
    {
        return $this->belongsTo(PresentationVisibility::class)
            ->select('id', 'title');
    }

    public function presentationTheme(): BelongsTo
    {
        return $this->belongsTo(PresentationTheme::class)
            ->select('id', 'title');
    }

    public function slides(): HasMany
    {
        return $this->hasMany(PresentationSlide::class)
            ->orderBy('order', 'desc');
    }
}
