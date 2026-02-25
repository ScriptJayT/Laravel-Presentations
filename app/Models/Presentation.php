<?php

namespace App\Models;

use App\Traits\CastUpdatedAtAsDiff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentation extends Model
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
        'user',
        'presentationVisibility',
        'presentationTheme',
        'presentationScript',
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
        return $this->belongsTo(User::class);
    }

    public function presentationScript(): BelongsTo
    {
        return $this->belongsTo(PresentationScript::class);
    }

    public function presentationVisibility(): BelongsTo
    {
        return $this->belongsTo(PresentationVisibility::class);
    }

    public function presentationTheme(): BelongsTo
    {
        return $this->belongsTo(PresentationTheme::class);
    }

    public function slides(): HasMany
    {
        return $this->hasMany(PresentationSlide::class);
    }
}
