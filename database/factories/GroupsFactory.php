<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Groups;
use App\Models\Promotions;
use App\Models\Media;

class GroupsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Groups::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'promotion_id' => Promotions::factory(),
            'image_id' => null, // Mettre à null par défaut pour éviter des erreurs de relation
        ];
    }
}
