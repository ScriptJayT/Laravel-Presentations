<?php

namespace Database\Factories;

use App\Models\PresentationScript;
use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Presentation>
 */
class PresentationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rules = PresentationVisibility::all();
        $id = $rules->count() < 1
            ? PresentationVisibility::factory()
            : $rules->first()->id;

        return [
            'title' => fake()->text(10),
            'user_id' => User::factory(),
            'presentation_visibility_id' => $id,
            'presentation_script_id' => PresentationScript::factory(),
            'presentation_theme_id' => PresentationTheme::factory(),
            'slug' => Str::of(fake()->text(10))->slug(),
        ];
    }
}
