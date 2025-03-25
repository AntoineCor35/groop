<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des utilisateurs avec différents rôles
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'type' => 'Staff',
                'avatar_id' => 1, // Référence au media créé dans MediaSeeder
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Modérateur',
                'email' => 'moderateur@example.com',
                'password' => Hash::make('password'),
                'role' => 'Modérateur',
                'type' => 'Staff',
                'avatar_id' => null,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Utilisateur',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => 'Utilisateur',
                'type' => 'Member',
                'avatar_id' => null,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Invité',
                'email' => 'invite@example.com',
                'password' => Hash::make('password'),
                'role' => 'Invité',
                'type' => 'Guest',
                'avatar_id' => null,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            // Vérifier si l'utilisateur existe déjà avant de le créer
            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            } else {
                // Mettre à jour l'utilisateur existant avec les nouvelles données
                User::where('email', $userData['email'])->update([
                    'name' => $userData['name'],
                    'role' => $userData['role'],
                    'type' => $userData['type'],
                    'avatar_id' => $userData['avatar_id'],
                ]);
            }
        }

        // Créer quelques utilisateurs supplémentaires avec faker
        // Limiter le nombre pour éviter trop de données de test
        // if (User::count() < 10) {
        //     User::factory()->count(5)->create();
        // }
    }
}
