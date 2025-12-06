<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Log;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Create 5 dummy users
        User::factory()->count(5)->create();

        // 2️⃣ Create 3 dummy projects
        Project::create([
            'user_id' => 1,
            'project_name' => 'Project Alpha',
            'title' => 'Alpha Development',
            'description' => 'Dummy description for Project Alpha.',
            'image' => null,
            'target_amount' => 100000,
            'current_amount' => 25000,
            'status' => 'approved', // <-- changed from 'active'
        ]);

        Project::create([
            'user_id' => 2,
            'project_name' => 'Project Beta',
            'title' => 'Beta Prototype',
            'description' => 'Dummy description for Project Beta.',
            'image' => null,
            'target_amount' => 75000,
            'current_amount' => 15000,
            'status' => 'pending',
        ]);

        Project::create([
            'user_id' => 3,
            'project_name' => 'Project Gamma',
            'title' => 'Gamma Expansion',
            'description' => 'Dummy description for Project Gamma.',
            'image' => null,
            'target_amount' => 200000,
            'current_amount' => 100000,
            'status' => 'approved', // <-- changed from 'active'
        ]);

        // 3️⃣ Create dummy logs for monitoring
        Log::create([
            'user_id' => 1,
            'action_type' => 'Investment Made',
            'remarks' => '(UserID: 1) invested P5,000 in Project Alpha',
        ]);

        Log::create([
            'user_id' => 2,
            'action_type' => 'Project Created',
            'remarks' => '(UserID: 2) created Project Beta',
        ]);

        Log::create([
            'user_id' => 3,
            'action_type' => 'Project Approved',
            'remarks' => '(UserID: 3) approved Project Gamma',
        ]);
    }
}
