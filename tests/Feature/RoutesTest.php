<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    private function login()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_app_is_live()
    {
        $response = $this->get('/up');
        $response->assertOk();
    }

    public function test_homepage_is_accessible()
    {
        $response = $this->get(route('home'));
        $response->assertOk();
        $response = $this->get('/');
        $response->assertOk();
    }

    public function test_indexpages_are_inaccessible()
    {
        $response = $this->get('/presentations');
        $response->assertRedirect();
        $response = $this->get('/scripts');
        $response->assertRedirect();
    }

    public function test_dashboardpages_are_inaccessible_when_guest()
    {
        $response = $this->get('/dashboard/presentations');
        $response->assertRedirect();
        $response = $this->get('/dashboard/scripts');
        $response->assertRedirect();
        $response = $this->get('/dashboard/users');
        $response->assertRedirect();
    }

    public function test_adminpages_are_accessible_when_user()
    {
        $this->login();

        $response = $this->get('/dashboard/presentations');
        $response->assertOk();
        $response = $this->get('/dashboard/scripts');
        $response->assertOk();
        $response = $this->get('/dashboard/users');
        $response->assertOk();
    }

    public function test_profilepages_are_inaccessible_when_guest()
    {
        $response = $this->get('/settings/profile');
        $response->assertRedirect();
    }

    public function test_profilepages_are_accessible_when_user()
    {
        $this->login();

        $response = $this->get('/settings/profile');
        $response->assertOk();
    }
}
