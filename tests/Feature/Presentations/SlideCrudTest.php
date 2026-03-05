<?php

namespace Tests\Feature\Presentations;

use App\Enums\Visibility;
use App\Models\Presentation;
use App\Models\PresentationScript;
use App\Models\PresentationSlide;
use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SlideCrudTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function slide_can_be_made()
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
        $presentation = Presentation::factory()->create([
            'presentation_theme_id' => $theme->id,
            'presentation_visibility_id' => $rule->id,
            'presentation_script_id' => $script->id,
        ]);
        $slide = PresentationSlide::create([
            'title' => 'Title',
            'content' => '',
            'order' => 0,
            'presentation_id' => $presentation->id,
            'presentation_theme_id' => $theme->id,
        ]);
        $this->assertEquals($slide->title, 'Title');
        $this->assertNotNull($slide->presentation);
        $this->assertNotNull($slide->presentationTheme);
    }

    private function setupSlide(Visibility $_visibility = Visibility::PUBLIC): PresentationSlide
    {
        $user = User::factory()->create();
        $theme = PresentationTheme::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => $_visibility->title(),
            'name' => 'Gibberish',
        ]);
        $script = PresentationScript::factory()->create([
            'user_id' => $user->id,
            'presentation_visibility_id' => $rule->id,
        ]);
        $presentation = Presentation::factory()->create([
            'presentation_theme_id' => $theme->id,
            'presentation_visibility_id' => $rule->id,
            'presentation_script_id' => $script->id,
        ]);

        return PresentationSlide::create([
            'title' => 'Title',
            'content' => '',
            'order' => 0,
            'presentation_id' => $presentation->id,
            'presentation_theme_id' => $theme->id,
        ]);
    }

    #[Test]
    public function admin_public_slide_can_be_updated_by_other_user()
    {
        // setup
        $slide = $this->setupSlide();
        $presentation = $slide->presentation;
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_presentations', ['presentation' => $presentation->id]))
            ->patch(
                route('admin_slide.update', ['slide' => $slide->id]),
                [
                    'title' => 'Slide Title',
                    'content' => '',
                    'order' => 10,
                ]
            );
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();
        $this->assertEquals($slide->refresh()->title, 'Slide Title');
    }

    #[Test]
    public function admin_protected_slide_can_be_updated_by_other_user()
    {
        // setup
        $slide = $this->setupSlide(Visibility::PROTECTED);
        $presentation = $slide->presentation;
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_presentations', ['presentation' => $presentation->id]))
            ->patch(
                route('admin_slide.update', ['slide' => $slide->id]),
                [
                    'title' => 'Slide Title',
                    'content' => '',
                    'order' => 10,
                ]
            );
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();
        $this->assertEquals($slide->refresh()->title, 'Slide Title');
    }

    #[Test]
    public function admin_private_slide_cannot_be_updated_by_other_user()
    {
        // setup
        $slide = $this->setupSlide(Visibility::PRIVATE);
        $initialTitle = $slide->title;
        $presentation = $slide->presentation;
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_presentations', ['presentation' => $presentation->id]))
            ->patch(
                route('admin_slide.update', ['slide' => $slide->id]),
                [
                    'title' => 'Slide Title',
                    'content' => '',
                    'order' => 10,
                ]
            );
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();
        $this->assertEquals($slide->refresh()->title, $initialTitle);
    }

    #[Test]
    public function admin_public_slide_can_be_deleted_by_other_user()
    {
        // setup
        $slide = $this->setupSlide();
        $presentation = $slide->presentation;
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_presentations', ['presentation' => $presentation->id]))
            ->delete(
                route('admin_slide.destroy', ['slide' => $slide->id])
            );
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();
        $this->expectException(ModelNotFoundException::class);
        $slide->refresh();
    }

    #[Test]
    public function admin_protected_slide_can_be_deleted_by_other_user()
    {
        // setup
        $slide = $this->setupSlide(Visibility::PROTECTED);
        $presentation = $slide->presentation;
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_presentations', ['presentation' => $presentation->id]))
            ->delete(
                route('admin_slide.destroy', ['slide' => $slide->id])
            );
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();
        $this->expectException(ModelNotFoundException::class);
        $slide->refresh();
    }

    #[Test]
    public function admin_private_slide_cannot_be_deleted_by_other_user()
    {
        // setup
        $slide = $this->setupSlide(Visibility::PRIVATE);
        $initialTitle = $slide->title;
        $presentation = $slide->presentation;
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_presentations', ['presentation' => $presentation->id]))
            ->delete(
                route('admin_slide.destroy', ['slide' => $slide->id])
            );
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();
        $this->assertEquals($slide->refresh()->title, $initialTitle);
    }
}
