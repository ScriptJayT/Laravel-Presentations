<?php

namespace Database\Seeders;

use App\Models\Presentation;
use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $botUser = User::factory()->create([
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'password' => Hash::make(uniqid()),
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        PresentationVisibility::factory()->create([ 'title' => "public" ]); 
        $visibilityRule = PresentationVisibility::factory()->create([ 'title' => "login" ]); 
        PresentationVisibility::factory()->create([ 'title' => "creator" ]);

        $defaultTheme = PresentationTheme::factory()->create([ 'title' => "base" ]);
        PresentationTheme::factory()->create([ 'title' => "light" ]);

        Presentation::factory()->create([
            'title' => "Welcome",
            'slug' => Str::of("Welcome")->slug(),
            'user_id' => $botUser->id,
            'presentation_visibility_id' => $visibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
        ]);
    }
}
