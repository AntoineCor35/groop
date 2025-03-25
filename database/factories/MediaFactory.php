<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Media;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'model_type' => fake()->word(),
            'model_id' => fake()->numberBetween(-10000, 10000),
            'uuid' => fake()->uuid(),
            'collection_name' => fake()->word(),
            'name' => fake()->name(),
            'file_name' => fake()->word(),
            'mime_type' => fake()->word(),
            'disk' => fake()->word(),
            'conversions_disk' => fake()->word(),
            'size' => fake()->numberBetween(-10000, 10000),
            'manipulations' => '{}',
            'custom_properties' => '{}',
            'generated_conversions' => '{}',
            'responsive_images' => '{}',
            'order_column' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
