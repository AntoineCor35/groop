<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userEntities = [
            [
                'user_id' => 1, // Admin
                'entity_id' => 1, // Université Paris-Saclay
            ],
            [
                'user_id' => 1, // Admin
                'entity_id' => 2, // École Polytechnique
            ],
            [
                'user_id' => 2, // Modérateur
                'entity_id' => 1, // Université Paris-Saclay
            ],
            [
                'user_id' => 3, // Utilisateur
                'entity_id' => 1, // Université Paris-Saclay
            ],
            [
                'user_id' => 4, // Invité
                'entity_id' => 2, // École Polytechnique
            ],
            [
                'user_id' => 5,
                'entity_id' => 3, // CentraleSupélec
            ],
            [
                'user_id' => 6,
                'entity_id' => 3, // CentraleSupélec
            ],
            [
                'user_id' => 7,
                'entity_id' => 4, // ISEP
            ],
            [
                'user_id' => 8,
                'entity_id' => 4, // ISEP
            ],
            [
                'user_id' => 9,
                'entity_id' => 2, // École Polytechnique
            ],
            [
                'user_id' => 10,
                'entity_id' => 1, // Université Paris-Saclay
            ],
        ];

        DB::table('entities_user')->insert($userEntities);
    }
}
