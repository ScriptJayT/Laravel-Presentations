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

    private function assertRoutes(array $_routes, bool $_ok = true)
    {
        foreach ($_routes as $_ => $_route) {
            $response = $this->get($_route);
            if ($_ok) {
                $response->assertOk();
            } else {
                $response->assertRedirect();
            }
        }
    }

    public function test_app_is_live()
    {
        $response = $this->get('/up');
        $response->assertOk();
    }

    public function test_homepage_is_accessible()
    {
        $this->assertRoutes(['/', route('home')]);
    }

    public function test_indexpages_are_inaccessible()
    {
        $this->assertRoutes(['/presentations', '/scripts'], false);
    }

    public function test_dashboardpages_are_inaccessible_when_guest()
    {
        $this->assertRoutes(
            [
                '/dashboard/presentations', route('admin_presentation_index'),
                '/dashboard/scripts', route('admin_script_index'),
                '/dashboard/users', route('admin_user_index'),
            ],
            false
        );
    }

    public function test_adminpages_are_accessible_when_user()
    {
        $this->login();
        $this->assertRoutes([
            '/dashboard/presentations', route('admin_presentation_index'),
            '/dashboard/scripts', route('admin_script_index'),
            '/dashboard/users', route('admin_user_index'),
        ]);
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
