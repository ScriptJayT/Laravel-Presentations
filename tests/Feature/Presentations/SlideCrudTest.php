<?php

namespace Tests\Feature\Presentations;

use App\Enums\Visibility;
use App\Models\Presentation;
use App\Models\PresentationSlide;
use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
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
        $theme = PresentationTheme::factory()->create();
        $presentation = Presentation::factory()->create();
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
        $theme = PresentationTheme::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => $_visibility->title(),
        ]);
        $presentation = Presentation::factory()->create([
            'presentation_visibility_id' => $rule->id,
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
            ->assertStatus(403);
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
            ->assertStatus(403);
        $this->assertEquals($slide->refresh()->title, $initialTitle);
    }
}
