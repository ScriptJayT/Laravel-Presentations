<?php

namespace Tests\Feature\Presentations;

use App\Enums\Visibility;
use App\Models\Presentation;
use App\Models\PresentationScript;
use App\Models\PresentationSlide;
use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
use App\Models\User;
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

    private function setupScript(Visibility $_visibility = Visibility::PUBLIC) {}
}
