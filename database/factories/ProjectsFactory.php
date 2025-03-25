<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Projects;
use App\Models\Groups;
use App\Models\Media;

class ProjectsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Projects::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'group_id' => Groups::factory(),
            'icon' => fake()->word(),
            'image_id' => null, // Mettre à null par défaut pour éviter des erreurs de relation
        ];
    }
}
