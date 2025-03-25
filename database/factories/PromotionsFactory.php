<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Entities;
use App\Models\Promotions;
use App\Models\Media;

class PromotionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promotions::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'parent_promotion_id' => null,
            'image_id' => null, // Mettre à null par défaut pour éviter des erreurs de relation
            'entity_id' => Entities::factory(),
        ];
    }
}
