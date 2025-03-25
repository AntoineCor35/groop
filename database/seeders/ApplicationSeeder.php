<?php

namespace Database\Seeders;

use App\Models\Applications;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applications = [
            [
                'status' => 'approved',
                'project_id' => 1, // Plateforme E-learning
                'user_id' => 1, // Admin
                'commentaire' => 'Projet validé et approuvé.',
            ],
            [
                'status' => 'approved',
                'project_id' => 1, // Plateforme E-learning
                'user_id' => 2, // Modérateur
                'commentaire' => 'Accepté en tant que modérateur pour suivre le projet.',
            ],
            [
                'status' => 'approved',
                'project_id' => 1, // Plateforme E-learning
                'user_id' => 3, // Utilisateur
                'commentaire' => 'Accepté comme participant au projet.',
            ],
            [
                'status' => 'pending',
                'project_id' => 2, // App Mobile de Gestion du Temps
                'user_id' => 4, // Invité
                'commentaire' => 'Je souhaiterais participer à ce projet pour apprendre le développement mobile.',
            ],
            [
                'status' => 'approved',
                'project_id' => 3, // Système de Reconnaissance Faciale
                'user_id' => 1, // Admin
                'commentaire' => 'Projet approuvé par l\'administration.',
            ],
            [
                'status' => 'rejected',
                'project_id' => 3, // Système de Reconnaissance Faciale
                'user_id' => 4, // Invité
                'commentaire' => 'Candidature refusée par manque d\'expérience en IA.',
            ],
            [
                'status' => 'approved',
                'project_id' => 4, // Chatbot d'Assistance Académique
                'user_id' => 2, // Modérateur
                'commentaire' => 'Participera en tant que modérateur du projet.',
            ],
        ];

        foreach ($applications as $application) {
            Applications::create($application);
        }

        // // Créer quelques applications supplémentaires
        // Applications::factory()->count(5)->create();
    }
}
