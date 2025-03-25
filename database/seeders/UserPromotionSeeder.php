<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userPromotions = [
            [
                'user_id' => 1, // Admin
                'promotion_id' => 1, // Bachelor Informatique 2023
            ],
            [
                'user_id' => 1, // Admin
                'promotion_id' => 2, // Master Informatique 2023
            ],
            [
                'user_id' => 2, // Modérateur
                'promotion_id' => 2, // Master Informatique 2023
            ],
            [
                'user_id' => 2, // Modérateur
                'promotion_id' => 3, // Master IA 2023
            ],
            [
                'user_id' => 3, // Utilisateur
                'promotion_id' => 1, // Bachelor Informatique 2023
            ],
            [
                'user_id' => 4, // Invité
                'promotion_id' => 4, // Ingénieur 2023
            ],
            [
                'user_id' => 5,
                'promotion_id' => 5, // Ingénieur IA 2023
            ],
            [
                'user_id' => 6,
                'promotion_id' => 3, // Master IA 2023
            ],
            [
                'user_id' => 7,
                'promotion_id' => 1, // Bachelor Informatique 2023
            ],
            [
                'user_id' => 8,
                'promotion_id' => 4, // Ingénieur 2023
            ],
            [
                'user_id' => 9,
                'promotion_id' => 5, // Ingénieur IA 2023
            ],
            [
                'user_id' => 10,
                'promotion_id' => 2, // Master Informatique 2023
            ],
        ];

        DB::table('promotions_user')->insert($userPromotions);
    }
}
