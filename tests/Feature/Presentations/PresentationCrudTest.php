<?php

namespace Tests\Feature\Settings;

use App\Enums\Visibility;
use App\Models\Presentation;
use App\Models\PresentationScript;
use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PresentationCrudTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function presentation_tables_can_be_setup()
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

    #[Test]
    public function presentation_can_be_made()
    {
        $user = User::factory()->create();
        $theme = PresentationTheme::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => Visibility::PROTECTED->title(),
            'name' => 'Gibberish',
        ]);
        $script = PresentationScript::factory()->create([
            'user_id' => $user->id,
            'presentation_visibility_id' => $rule->id,
        ]);

        $presentation = Presentation::create([
            'title' => 'Presentation',
            'slug' => 'presentation',
            'user_id' => $user->id,
            'presentation_theme_id' => $theme->id,
            'presentation_visibility_id' => $rule->id,
            'presentation_script_id' => $script->id,
        ]);

        $this->assertEquals($presentation->title, 'Presentation');
        $this->assertNotNull($presentation->user);
        $this->assertEquals($presentation->user->id, $user->id);
        $this->assertEquals($presentation->presentationVisibility->name, 'Gibberish');
        $this->assertNotNull($presentation->presentationScript);
        $this->assertNotNull($presentation->presentationTheme);
    }

    #[Test]
    public function admin_public_presentation_can_be_read_by_other_user()
    {
        // setup
        $user = User::factory()->create();
        $theme = PresentationTheme::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => Visibility::PUBLIC->title(),
            'name' => 'Gibberish',
        ]);
        $presentation = Presentation::create([
            'title' => 'Presentation',
            'slug' => 'presentation',
            'user_id' => $user->id,
            'presentation_theme_id' => $theme->id,
            'presentation_visibility_id' => $rule->id,
        ]);

        // test
        $this->loginRandomUser();
        $response = $this->get(route('admin_presentations', ['presentation' => $presentation->id]));
        $response->assertOk();
    }

    #[Test]
    public function admin_protected_presentation_can_be_read_by_other_user()
    {
        // setup
        $user = User::factory()->create();
        $theme = PresentationTheme::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => Visibility::PROTECTED->title(),
            'name' => 'Gibberish',
        ]);
        $presentation = Presentation::create([
            'title' => 'Presentation',
            'slug' => 'presentation',
            'user_id' => $user->id,
            'presentation_theme_id' => $theme->id,
            'presentation_visibility_id' => $rule->id,
        ]);

        // test
        $this->loginRandomUser();
        $response = $this->get(route('admin_presentations', ['presentation' => $presentation->id]));
        $response->assertOk();
    }

    #[Test]
    public function admin_private_presentation_cannot_be_read_by_other_user()
    {
        // setup
        $user = User::factory()->create();
        $theme = PresentationTheme::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => Visibility::PRIVATE->title(),
            'name' => 'Gibberish',
        ]);
        $presentation = Presentation::create([
            'title' => 'Presentation',
            'slug' => 'presentation',
            'user_id' => $user->id,
            'presentation_theme_id' => $theme->id,
            'presentation_visibility_id' => $rule->id,
        ]);

        // test
        $this->loginRandomUser();
        $response = $this->get(route('admin_presentations', ['presentation' => $presentation->id]));
        $response->assertRedirect();
    }

    #[Test]
    public function admin_protected_presentation_can_be_updated_by_other_user()
    {
        // setup
        $user = User::factory()->create();
        $theme = PresentationTheme::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => Visibility::PROTECTED->title(),
            'name' => 'Gibberish',
        ]);
        $presentation = Presentation::create([
            'title' => 'Presentation',
            'slug' => 'presentation',
            'user_id' => $user->id,
            'presentation_theme_id' => $theme->id,
            'presentation_visibility_id' => $rule->id,
        ]);

        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_presentations', ['presentation' => $presentation->id]))
            ->patch(
                route('admin_presentation.update', ['presentation' => $presentation->id]),
                [
                    'title' => 'Presentation 2',
                    'slug' => 'presentation-2',
                    'visibility' => $rule->id,
                    'script' => null,
                ]
            );
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();
        $this->assertEquals($presentation->refresh()->title, 'Presentation 2');

    }

    #[Test]
    public function admin_private_presentation_cannot_be_updated_by_other_user()
    {
        // setup
        $user = User::factory()->create();
        $theme = PresentationTheme::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => Visibility::PRIVATE->title(),
            'name' => 'Gibberish',
        ]);
        $presentation = Presentation::create([
            'title' => 'Presentation',
            'slug' => 'presentation',
            'user_id' => $user->id,
            'presentation_theme_id' => $theme->id,
            'presentation_visibility_id' => $rule->id,
        ]);

        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_presentations', ['presentation' => $presentation->id]))
            ->patch(
                route('admin_presentation.update', ['presentation' => $presentation->id]),
                [
                    'title' => 'Presentation 2',
                    'slug' => 'presentation-2',
                    'visibility' => $rule->id,
                    'script' => null,
                ]
            );
        $response
            // ->assertSessionHasErrors()
            ->assertRedirect();
        $this->assertEquals($presentation->refresh()->title, 'Presentation');

    }
}
