<?php

namespace Tests\Feature\Presentations;

use App\Enums\Visibility;
use App\Models\PresentationScript;
use App\Models\PresentationVisibility;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ScriptCrudTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function script_tables_can_be_setup()
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
    }

    #[Test]
    public function script_can_be_made()
    {
        $user = User::factory()->create();
        $rule = PresentationVisibility::factory()->create();

        $presentation = PresentationScript::create([
            'title' => 'Presentation',
            'content' => 'content',
            'user_id' => $user->id,
            'presentation_visibility_id' => $rule->id,
        ]);

        $this->assertEquals($presentation->title, 'Presentation');
        $this->assertNotNull($presentation->user);
        $this->assertEquals($presentation->user->id, $user->id);
        $this->assertNotNull($presentation->presentationVisibility);
    }

    private function setupScript(Visibility $_visibility = Visibility::PUBLIC): PresentationScript
    {
        $user = User::factory()->create();
        $rule = PresentationVisibility::factory()->create([
            'title' => $_visibility->title(),
        ]);

        return PresentationScript::create([
            'title' => 'script',
            'content' => 'script content in markdown',
            'user_id' => $user->id,
            'presentation_visibility_id' => $rule->id,
        ]);
    }

    #[Test]
    public function admin_script_can_be_created()
    {
        PresentationVisibility::factory()->create([
            'title' => Visibility::PRIVATE->title(),
        ]);
        $response = $this->loginRandomUser()
            ->from(route('admin_script_index'))
            ->post(route('admin_script.store'), [
                'title' => 'Script Title',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirectBack();
        $this->assertDatabaseCount('presentation_scripts', 1);
    }

    #[Test]
    public function admin_public_script_can_be_read_by_other_user()
    {
        // setup
        $model = $this->setupScript();
        // test
        $this->loginRandomUser();
        $response = $this->get(route('admin_scripts', ['script' => $model->id]));
        $response->assertOk();
    }

    #[Test]
    public function admin_protected_script_can_be_read_by_other_user()
    {
        // setup
        $model = $this->setupScript(Visibility::PROTECTED);
        // test
        $this->loginRandomUser();
        $response = $this->get(route('admin_scripts', ['script' => $model->id]));
        $response->assertOk();
    }

    #[Test]
    public function admin_private_script_cannot_be_read_by_other_user()
    {
        // setup
        $model = $this->setupScript(Visibility::PRIVATE);
        // test
        $this->loginRandomUser();
        $response = $this->get(route('admin_scripts', ['script' => $model->id]));
        $response->assertRedirect();
    }

    #[Test]
    public function admin_public_script_can_be_updated_by_other_user()
    {
        // setup
        $model = $this->setupScript();
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_scripts', ['script' => $model->id]))
            ->patch(route('admin_script.update', ['script' => $model->id]), [
                'title' => 'title 2',
                'content' => '',
                'order' => 0,
                'visibility' => $model->presentationVisibility->id,
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();
        $this->assertEquals($model->refresh()->title, 'title 2');
    }

    #[Test]
    public function admin_protected_script_can_be_updated_by_other_user()
    {
        // setup
        $model = $this->setupScript(Visibility::PROTECTED);
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_scripts', ['script' => $model->id]))
            ->patch(route('admin_script.update', ['script' => $model->id]), [
                'title' => 'title 2',
                'content' => '',
                'order' => 0,
                'visibility' => $model->presentationVisibility->id,
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();
        $this->assertEquals($model->refresh()->title, 'title 2');
    }

    #[Test]
    public function admin_private_script_cannot_be_updated_by_other_user()
    {
        // setup
        $model = $this->setupScript(Visibility::PRIVATE);
        $initialTitle = $model->title;

        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_scripts', ['script' => $model->id]))
            ->patch(route('admin_script.update', ['script' => $model->id]), [
                'title' => 'script 2',
                'content' => '',
                'order' => 0,
                'visibility' => $model->presentationVisibility->id,
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertStatus(403);
        $this->assertEquals($model->refresh()->title, $initialTitle);
    }

    #[Test]
    public function admin_public_script_can_be_deleted_by_other_user()
    {
        // setup
        $model = $this->setupScript();
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_scripts', ['script' => $model->id]))
            ->delete(route('admin_script.destroy', ['script' => $model->id]));
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->expectException(ModelNotFoundException::class);
        $model->refresh();
    }

    #[Test]
    public function admin_protected_script_can_be_deleted_by_other_user()
    {
        // setup
        $model = $this->setupScript(Visibility::PROTECTED);
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_scripts', ['script' => $model->id]))
            ->delete(route('admin_script.destroy', ['script' => $model->id]));
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->expectException(ModelNotFoundException::class);
        $model->refresh();
    }

    #[Test]
    public function admin_private_script_cannot_be_deleted_by_other_user()
    {
        // setup
        $model = $this->setupScript(Visibility::PRIVATE);
        $oldTitle = $model->title;
        // test
        $response = $this->loginRandomUser()
            ->from(route('admin_scripts', ['script' => $model->id]))
            ->delete(route('admin_script.destroy', ['script' => $model->id]));
        $response
            ->assertSessionHasNoErrors()
            ->assertStatus(403);

        $this->assertEquals($model->refresh()->title, $oldTitle);
    }
}
