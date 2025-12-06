<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_name' => $this->faker->company(),
            'title' => $this->faker->catchPhrase(),
            'description' => $this->faker->sentence(10),
            'status' => 'pending', // or 'active'
            'user_id' => 1, // adjust depending on your users table
        ];
    }
}
