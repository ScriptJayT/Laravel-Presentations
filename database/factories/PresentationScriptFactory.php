<?php

namespace Database\Factories;

use App\Models\PresentationVisibility;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PresentationScript>
 */
class PresentationScriptFactory extends Factory
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
            'content' => fake()->sentence(30),
            'user_id' => User::factory(),
            'presentation_visibility_id' => $id,
        ];
    }
}
