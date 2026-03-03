<?php

namespace Database\Seeders;

use App\Enums\Visibility;
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

        $publicVisibilityRule = PresentationVisibility::factory()->create([
            'title' => Visibility::PUBLIC->title(),
            'name' => 'Public',
        ]);
        $loginVisibilityRule = PresentationVisibility::factory()->create([
            'title' => Visibility::PROTECTED->title(),
            'name' => 'Protected',
        ]);
        $creatorVisibilityRule = PresentationVisibility::factory()->create([
            'title' => Visibility::PRIVATE->title(),
            'name' => 'Private',
        ]);

        $defaultTheme = PresentationTheme::factory()->create(['title' => 'base']);

        $examplePresentation = Presentation::factory()->create([
            'title' => 'Welcome to Hell\'Press',
            'slug' => Str::of('Welcome to Hell\'Press')->slug(),
            'user_id' => $botUser->id,
            'presentation_visibility_id' => $loginVisibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Presentations',
            'content' => '',
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Slides',
            'content' => '',
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Scripts',
            'content' => "Scripts are like mini-thesis \n\n You can optionally link your script to your presentation",
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Guards',
            'content' => "You can make presentations and scripts: \n- accessible to everyone \n- accessible to logged in users only \n- accessible to you alone",
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Markdown (MD)',
            'content' => "You can use markdown to scaffold your script and slides \n\n \*text\* => *italic* \n \*\*text\*\* => **strong** \n \*\*\*text\*\*\* => ***strong/italic*** \n\n- unordered \n- list \n\n1. ordered \n 1. list",
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Title Shift',
            'content' => "MD titles in slides and scripts are shifted down automatically: \n\n # \# h1 => h3 \n ## \## h2 => h4 \n ### \### h3 => h5 \n #### \#### h4 => h6 \n ##### \##### h5 => h6 \n ###### \###### h6 => h6",
        ]);

        Presentation::factory()->create([
            'title' => 'Hello world',
            'slug' => Str::of('Hello world')->slug(),
            'user_id' => $botUser->id,
            'presentation_visibility_id' => $publicVisibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
        ]);

        $script = PresentationScript::factory()->create([
            'title' => 'My personal project',
            'user_id' => $testUser->id,
            'presentation_visibility_id' => $creatorVisibilityRule->id,
        ]);
        $scaffoldingPresentation = Presentation::factory()->create([
            'title' => 'My personal project',
            'slug' => Str::of('My personal project')->slug(),
            'user_id' => $testUser->id,
            'presentation_visibility_id' => $creatorVisibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
            'presentation_script_id' => $script->id,
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $scaffoldingPresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
        ]);
    }
}
