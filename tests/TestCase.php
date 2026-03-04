<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    //

    protected function loginRandomUser()
    {
        $user = User::factory()->create();

        return $this->actingAs($user);
    }

    protected function loginWith(User $user)
    {
        return $this->actingAs($user);
    }
}
