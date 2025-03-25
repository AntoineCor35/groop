<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Comments;
use App\Models\User;
use App\Models\Conversations;

class CommentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comments::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'comment' => fake()->text(),
            'user_id' => User::factory(),
            'conversation_id' => Conversations::factory(),
            'pinned' => fake()->boolean(),
        ];
    }
}
