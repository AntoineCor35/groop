<?php

namespace Database\Seeders;

use App\Models\Promotions;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotions = [
            [
                'name' => 'Bachelor Informatique 2023',
                'description' => 'Promotion Bachelor Informatique année 2023',
                'parent_promotion_id' => null,
                'image_id' => null,
                'entity_id' => 1, // Université Paris-Saclay
            ],
            [
                'name' => 'Master Informatique 2023',
                'description' => 'Promotion Master Informatique année 2023',
                'parent_promotion_id' => null,
                'image_id' => null,
                'entity_id' => 1, // Université Paris-Saclay
            ],
            [
                'name' => 'Master IA 2023',
                'description' => 'Master Intelligence Artificielle année 2023',
                'parent_promotion_id' => 2, // Master Informatique
                'image_id' => null,
                'entity_id' => 1, // Université Paris-Saclay
            ],
            [
                'name' => 'Ingénieur 2023',
                'description' => 'Promotion Ingénieur année 2023',
                'parent_promotion_id' => null,
                'image_id' => null,
                'entity_id' => 2, // École Polytechnique
            ],
            [
                'name' => 'Ingénieur IA 2023',
                'description' => 'Ingénieur spécialité Intelligence Artificielle année 2023',
                'parent_promotion_id' => 4, // Ingénieur
                'image_id' => null,
                'entity_id' => 2, // École Polytechnique
            ],
        ];

        foreach ($promotions as $promotion) {
            Promotions::create($promotion);
        }

        // // Créer quelques promotions supplémentaires avec faker
        // Promotions::factory()->count(5)->create();
    }
}
