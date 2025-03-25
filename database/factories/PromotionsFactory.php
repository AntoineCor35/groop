<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Entity;
use App\Models\Medium;
use App\Models\Promotion;
use App\Models\Promotions;

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
            'parent_promotion_id' => Promotion::factory(),
            'image_id' => Medium::factory(),
            'entity_id' => Entity::factory(),
        ];
    }
}
