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
        User::factory()->create([
            'name' => 'Hestia',
            'email' => 'main@hellpress.dev',
            'password' => Hash::make('password'),
        ]);
        $botUser = User::factory()->create([
            'name' => 'Bot 🤖',
            'email' => 'bot@hellpress.dev',
            'password' => Hash::make(uniqid()),
        ]);

        $publicVisibilityRule = PresentationVisibility::factory()->create([
            'title' => Visibility::PUBLIC->title(),
            'name' => 'Public',
        ]);
        $loginVisibilityRule = PresentationVisibility::factory()->create([
            'title' => Visibility::PROTECTED->title(),
            'name' => 'Protected',
        ]);
        $privateVisibilityRule = PresentationVisibility::factory()->create([
            'title' => Visibility::PRIVATE->title(),
            'name' => 'Private',
        ]);

        $defaultTheme = PresentationTheme::factory()->create(['title' => 'base']);

        $exampleScript = PresentationScript::factory()->create([
            'title' => 'Welcome to Hell\'Press',
            'user_id' => $botUser->id,
            'presentation_visibility_id' => $loginVisibilityRule->id,
        ]);
        $examplePresentation = Presentation::factory()->create([
            'title' => 'Welcome to Hell\'Press',
            'slug' => Str::of('Welcome to Hell\'Press')->slug(),
            'user_id' => $botUser->id,
            'presentation_visibility_id' => $loginVisibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
            'presentation_script_id' => $exampleScript->id,
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Presentations',
            'content' => "Hell'Press brings your presentations online and ensures you remain the owner. \n\nNo need for propriatery software that steals your presentation and makes it unreadable or uneditable for you elsewhere due to their obfuscation.\n\nSimple text editing for quick n easy presentations.",
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Slides',
            'content' => "Surprise, a presentation is made up out of slides, \nwho'd thunk it.",
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
            'content' => "You can use markdown to scaffold your script and slides, though it is only supported in the content slot. \n\nNeed a [cheat sheet](https://www.markdownguide.org/cheat-sheet/)? \nOr: go to the last slide.",
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Title Shift',
            'content' => "MD titles in slides and scripts are shifted down automatically: \n'\# title' which would be an h1- shall be rendered as an h3 in slides, for example. \n\nSo you don't need to worry about any semantic differences in your text versus the actual render.",
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Render Test',
            'content' => "\n\n# \# title h1 \n\n## \#\# title h2 \n\n### \#\#\# title h3 \n\n#### \#\#\#\# title h4 \n\n##### \#\#\#\#\# title h5 \n\n###### \#\#\#\#\#\# title h6 \n\n\*text\* => *italic* \n\*\*text\*\* => **strong** \n\*\*\*text\*\*\* => ***italic/strong*** \n\~\~text\~\~ => ~~strikethrough~~ \n\`text\` => `code` \n\=\=text\=\= => ==highlight== \n\n- unordered list \n- with \+ \n- or \- \n- or \* \n\n1. ordered list \n1. with 1.  \n\n- [ ] task \n- [x] finished \n\nterm \n: definition \n\nterm \n: definition \n\n> blockquote with \> \n\nSeperator with \-\-\-: \n\n--- \n\n```\ncodeblock: \n\```\ncode\n\```\n```",
        ]);

        Presentation::factory()->create([
            'title' => 'Hello world',
            'slug' => Str::of('Hello world')->slug(),
            'user_id' => $botUser->id,
            'presentation_visibility_id' => $publicVisibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
            'presentation_script_id' => null,
        ]);
        Presentation::factory()->create([
            'title' => 'Private Presentation',
            'slug' => Str::of('private')->slug(),
            'user_id' => $botUser->id,
            'presentation_visibility_id' => $privateVisibilityRule->id,
            'presentation_theme_id' => $defaultTheme->id,
            'presentation_script_id' => null,
        ]);
    }
}
