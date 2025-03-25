<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRoles = [
            [
                'user_id' => 1, // Admin
                'role_id' => 1, // Admin
            ],
            [
                'user_id' => 2, // Modérateur
                'role_id' => 2, // Modérateur
            ],
            [
                'user_id' => 3, // Utilisateur
                'role_id' => 3, // Utilisateur
            ],
            [
                'user_id' => 4, // Invité
                'role_id' => 4, // Invité
            ],
            // Ajouter des rôles pour les utilisateurs générés par faker
            [
                'user_id' => 5,
                'role_id' => 3, // Utilisateur
            ],
            [
                'user_id' => 6,
                'role_id' => 3, // Utilisateur
            ],
            [
                'user_id' => 7,
                'role_id' => 3, // Utilisateur
            ],
            [
                'user_id' => 8,
                'role_id' => 4, // Invité
            ],
            [
                'user_id' => 9,
                'role_id' => 4, // Invité
            ],
            [
                'user_id' => 10,
                'role_id' => 2, // Modérateur
            ],
        ];

        DB::table('roles_user')->insert($userRoles);
    }
}
