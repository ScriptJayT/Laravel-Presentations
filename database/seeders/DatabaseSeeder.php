<?php

namespace Database\Seeders;

use App\Models\PresentationTheme;
use App\Models\PresentationVisibility;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        PresentationVisibility::factory()->create([ 'title' => "public"  ]); 
        PresentationVisibility::factory()->create([ 'title' => "login"   ]); 
        PresentationVisibility::factory()->create([ 'title' => "creator" ]);

        PresentationTheme::factory()->create([ 'title' => "base" ]);
        PresentationTheme::factory()->create([ 'title' => "light" ]);
    }
}
