<?php

namespace Tests\Feature\Settings;

use App\Enums\Visibility;
use App\Models\Presentation;
use App\Models\PresentationScript;
use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PresentationCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_presentation_tables_can_be_setup()
    {
        PresentationVisibility::factory()->create([
            'title' => Visibility::PUBLIC->title(),
            'name' => 'Gibberish',
        ]);
        PresentationVisibility::factory()->create([
            'title' => Visibility::PRIVATE->title(),
            'name' => 'Gibberish',
        ]);
        PresentationVisibility::factory()->create([
            'title' => Visibility::PROTECTED->title(),
            'name' => 'Gibberish',
        ]);
        $rules = PresentationVisibility::all();
        $this->assertCount(3, $rules->all());

        PresentationTheme::factory()->create();
        $themes = PresentationTheme::all();
        $this->assertCount(1, $themes->all());
    }

    public function test_presentation_can_be_made()
    {
        $user = User::factory()->create();
        $theme = PresentationTheme::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => Visibility::PROTECTED->title(),
            'name' => 'Gibberish',
        ]);

        $script = PresentationScript::factory()->create();

        $presentation = Presentation::create([
            'title' => 'Presentation',
            'slug' => 'presentation',
            'user_id' => $user->id,
            'presentation_theme_id' => $theme->id,
            'presentation_visibility_id' => $rule->id,
            'presentation_script_id' => $script,
        ]);

        $this->assertEquals($presentation->title, 'Presentation');
    }
}
