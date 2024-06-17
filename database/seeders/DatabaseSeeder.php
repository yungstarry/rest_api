<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user =  User::factory()->create([
            'name' => 'Test User',
            'email' => 'wc@yahoo.com',
            'password' => '123456'
        ]);
        // Create 2 projects for the user
        Project::factory()->count(2)->create(
            ['user_id' => $user->id,]
        );

        
    }
}
