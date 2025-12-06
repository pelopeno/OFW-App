<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::create([
            'project_name' => 'Project 1',
            'title' => 'Website Development',
            'description' => 'Develop a responsive website for a local business.',
            'status' => 'pending',
            'user_id' => 1, // must match an existing user
            'target_amount' => 5000, // example amount
        ]);

        Project::create([
            'project_name' => 'Project 2',
            'title' => 'Mobile App',
            'description' => 'Create a mobile application for a food delivery service.',
            'status' => 'pending',
            'user_id' => 2,
            'target_amount' => 10000,
        ]);

        Project::create([
            'project_name' => 'Project 3',
            'title' => 'E-learning Platform',
            'description' => 'Build an e-learning platform for online courses.',
            'status' => 'pending',
            'user_id' => 3,
            'target_amount' => 15000,
        ]);
    }
}
