<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

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
}
