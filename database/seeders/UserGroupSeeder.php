<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userGroups = [
            [
                'user_id' => 1, // Admin
                'group_id' => 1, // Groupe A - Bachelor Info 2023
            ],
            [
                'user_id' => 1, // Admin
                'group_id' => 3, // Groupe A - Master Info 2023
            ],
            [
                'user_id' => 2, // Modérateur
                'group_id' => 3, // Groupe A - Master Info 2023
            ],
            [
                'user_id' => 2, // Modérateur
                'group_id' => 5, // Groupe A - Master IA 2023
            ],
            [
                'user_id' => 3, // Utilisateur
                'group_id' => 1, // Groupe A - Bachelor Info 2023
            ],
            [
                'user_id' => 3, // Utilisateur
                'group_id' => 2, // Groupe B - Bachelor Info 2023
            ],
            [
                'user_id' => 4, // Invité
                'group_id' => 6, // Groupe A - Ingénieur 2023
            ],
            [
                'user_id' => 5,
                'group_id' => 5, // Groupe A - Master IA 2023
            ],
            [
                'user_id' => 6,
                'group_id' => 4, // Groupe B - Master Info 2023
            ],
            [
                'user_id' => 7,
                'group_id' => 2, // Groupe B - Bachelor Info 2023
            ],
            [
                'user_id' => 8,
                'group_id' => 6, // Groupe A - Ingénieur 2023
            ],
            [
                'user_id' => 9,
                'group_id' => 6, // Groupe A - Ingénieur 2023
            ],
            [
                'user_id' => 10,
                'group_id' => 3, // Groupe A - Master Info 2023
            ],
        ];

        DB::table('groups_user')->insert($userGroups);
    }
}
