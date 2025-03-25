<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Applications;
use App\Models\Projects;
use App\Models\User;

class ApplicationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Applications::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(["pending", "approved", "rejected"]),
            'project_id' => Projects::factory(),
            'user_id' => User::factory(),
            'commentaire' => fake()->text(),
        ];
    }
}
