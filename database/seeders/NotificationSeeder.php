<?php

namespace Database\Seeders;

use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'user_id' => 1, // Admin
                'message' => 'Bienvenue sur la plateforme Groop !',
                'type' => 'welcome',
                'read_at' => Carbon::now()->subDays(29),
            ],
            [
                'user_id' => 1, // Admin
                'message' => 'Nouveau commentaire sur le projet "Plateforme E-learning"',
                'type' => 'comment',
                'read_at' => Carbon::now()->subDays(28),
            ],
            [
                'user_id' => 1, // Admin
                'message' => 'Vous avez été ajouté au projet "Système de Reconnaissance Faciale"',
                'type' => 'project',
                'read_at' => null,
            ],
            [
                'user_id' => 2, // Modérateur
                'message' => 'Bienvenue sur la plateforme Groop !',
                'type' => 'welcome',
                'read_at' => Carbon::now()->subDays(27),
            ],
            [
                'user_id' => 2, // Modérateur
                'message' => 'Vous avez été assigné comme modérateur du projet "Chatbot d\'Assistance Académique"',
                'type' => 'assignment',
                'read_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_id' => 2, // Modérateur
                'message' => 'Nouveau commentaire sur le projet "Chatbot d\'Assistance Académique"',
                'type' => 'comment',
                'read_at' => null,
            ],
            [
                'user_id' => 3, // Utilisateur
                'message' => 'Bienvenue sur la plateforme Groop !',
                'type' => 'welcome',
                'read_at' => Carbon::now()->subDays(25),
            ],
            [
                'user_id' => 3, // Utilisateur
                'message' => 'Votre candidature au projet "Plateforme E-learning" a été acceptée',
                'type' => 'application',
                'read_at' => Carbon::now()->subDays(24),
            ],
            [
                'user_id' => 3, // Utilisateur
                'message' => 'Nouveau commentaire sur le projet "App Mobile de Gestion du Temps"',
                'type' => 'comment',
                'read_at' => null,
            ],
            [
                'user_id' => 4, // Invité
                'message' => 'Bienvenue sur la plateforme Groop !',
                'type' => 'welcome',
                'read_at' => Carbon::now()->subDays(20),
            ],
            [
                'user_id' => 4, // Invité
                'message' => 'Votre candidature au projet "Système de Reconnaissance Faciale" a été refusée',
                'type' => 'application',
                'read_at' => null,
            ],
        ];

        foreach ($notifications as $notification) {
            Notifications::create($notification);
        }

        // // Créer quelques notifications supplémentaires avec faker
        // Notifications::factory()->count(20)->create();
    }
}
