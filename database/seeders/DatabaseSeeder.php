<?php

namespace Database\Seeders;

use App\Models\Presentation;
use App\Models\PresentationScript;
use App\Models\PresentationSlide;
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
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $publicVisibilityRule = PresentationVisibility::factory()
            ->create([
                'title' => 'public',
                'name' => 'Public',
            ]);
        $loginVisibilityRule = PresentationVisibility::factory()
            ->create([
                'title' => 'login',
                'name' => 'Protected',
            ]);
        $creatorVisibilityRule = PresentationVisibility::factory()
            ->create([
                'title' => 'creator',
                'name' => 'Private',
            ]);

        $defaultTheme = PresentationTheme::factory()->create(['title' => 'base']);
        PresentationTheme::factory()->create(['title' => 'light']);

        $examplePresentation = Presentation::factory()->create([
            'title' => 'Welcome',
            'slug' => Str::of('Welcome')->slug(),
            'user_id' => $botUser->id,
            'presentation_visibility_id' => $loginVisibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
        ]);
        PresentationSlide::factory(3)->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
        ]);

        $entryPresentation = Presentation::factory()->create([
            'title' => 'Hello world',
            'slug' => Str::of('Hello world')->slug(),
            'user_id' => $botUser->id,
            'presentation_visibility_id' => $publicVisibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $entryPresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'content' => "# h1 \n ## h2 \n ### h3 \n #### h4 \n ##### h5 \n ###### h6",
        ]);
        PresentationSlide::factory(2)->create([
            'presentation_id' => $entryPresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
        ]);

        PresentationScript::factory(3)->create();

        $script = PresentationScript::factory()->create();
        $scaffoldingPresentation = Presentation::factory()->create([
            'title' => 'My personal project',
            'slug' => Str::of('My personal project')->slug(),
            'user_id' => $testUser->id,
            'presentation_visibility_id' => $creatorVisibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
            'presentation_script_id' => $script->id,
        ]);
        PresentationSlide::factory(2)->create([
            'presentation_id' => $scaffoldingPresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
        ]);
    }
}
