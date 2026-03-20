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
        $renderTest = "# \# title h1 \n\n## \#\# title h2 \n\n### \#\#\# title h3 \n\n#### \#\#\#\# title h4 \n\n##### \#\#\#\#\# title h5 \n\n###### \#\#\#\#\#\# title h6 \n\n\*text\* => *italic* \n\*\*text\*\* => **strong** \n\*\*\*text\*\*\* => ***italic/strong*** \n\__text\__ => __underline__ \n\~text\~ => ~strikethrough~ or: \n\~\~text\~\~ => ~~strikethrough~~ \n\==text\== => ==highlight== \n\`text\` => `code` \n\n- unordered list \n- with `+` \n- or `-` \n- or `*` \n\n1. ordered list \n1. with `1.` \n\n- [ ] task list with `- [ ]` \n- [x] finished with `- [x]` \n\nterm \n: definition \n\nterm \n: definition \n\n> \> blockquote  \n\nSeperator with `---` \n\n--- \n\n```\ncodeblock: \n\```\ncode\n\```\n```";

        $exampleScript = PresentationScript::factory()->create([
            'title' => 'Welcome to Hell\'Press',
            'content' => "# What is Hell'Press? \n\nHell'Press is a web-app where you can build and showcase your presentations from scratch. \nYou build talks or scripts using the build-in sleak Markdown editor. \n\nUsing webtech means you can access your work everywhere, anytime as long as you have access to the interwebs. \n\n# What is Markdown? \n\nMarkdown(md) is a markup-language, very much like HTML is. It's very easy to lay out a simple document with plain text using it, with the options to indicate stress, importance, to mark certain words or phrases in your text; to make lists and todo's; to display tables of information. \nAll of that is possible with Markdown, that and more. And all of that is done using text-characters only. \n\n# Why Markdown? \n\nThe reasoning behind us choosing Markdown is to give full controll of content back to the user, you. Often a lot of richtext-editors like Word or G-Docs require their program to even be able to see *your* content. While to read/edit Markdown all you need is a simple plaintext-editor \nWe at Hell'Press were not a fan of this reliance on propriatery software. So we chose Markdown and provided the option in the editor to easily upload or download `.md`-files. \n\nWant to see how it works? \nCheck out the last section below the three lines for a list. \n\n---\n---\n---\n\n{$renderTest}",
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
            'content' => "Scripts are like mini-thesis \n\nYou can optionally link your script to your presentation",
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
            'content' => "You can use Markdown to scaffold your script and slides, though it is only supported in the content slot. \n\nWhat is [Markdown](/s/1)? \n\nNeed a [cheat sheet](https://www.markdownguide.org/cheat-sheet/)? \nOr: go to the last slide.",
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Title Shift',
            'content' => "MD titles in slides and scripts are shifted down automatically: \n\n'\# title' would be an \<h1\> \nbut gets rendered as an \<h3\> in slides, for example. \n\nSo you don't need to worry about any semantic differences in your text versus the actual render.",
        ]);
        PresentationSlide::factory()->create([
            'presentation_id' => $examplePresentation->id,
            'presentation_theme_id' => $defaultTheme->id,
            'title' => 'Render Test',
            'content' => $renderTest,
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
