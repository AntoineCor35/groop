<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Administrateur avec tous les droits',
            ],
            [
                'name' => 'Modérateur',
                'description' => 'Modérateur avec des droits limités',
            ],
            [
                'name' => 'Utilisateur',
                'description' => 'Utilisateur standard',
            ],
            [
                'name' => 'Invité',
                'description' => 'Accès limité en lecture seule',
            ],
        ];

        foreach ($roles as $role) {
            Roles::create($role);
        }
    }
}
