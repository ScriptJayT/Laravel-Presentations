<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Presentation extends Model
{
    use HasFactory;

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
            'created_at' => 'date:m/d/y',
        ];
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->diffForHumans(),
        );
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
