<?php

namespace Database\Seeders;

use App\Models\Projects;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Plateforme E-learning',
                'description' => 'Développement d\'une plateforme d\'apprentissage en ligne avec des cours interactifs et suivi de progression.',
                'group_id' => 1, // Groupe A - Bachelor Info 2023
                'icon' => 'heroicon-o-academic-cap',
                'image_id' => 3, // Référence au media créé dans MediaSeeder
            ],
            [
                'name' => 'Application Mobile de Gestion du Temps',
                'description' => 'Application mobile permettant de gérer son emploi du temps, ses tâches et de suivre sa productivité.',
                'group_id' => 1, // Groupe A - Bachelor Info 2023
                'icon' => 'heroicon-o-clock',
                'image_id' => null,
            ],
            [
                'name' => 'Système de Reconnaissance Faciale',
                'description' => 'Système de reconnaissance faciale utilisant des algorithmes d\'apprentissage profond pour identifier les personnes.',
                'group_id' => 3, // Groupe A - Master Info 2023
                'icon' => 'heroicon-o-user',
                'image_id' => null,
            ],
            [
                'name' => 'Chatbot d\'Assistance Académique',
                'description' => 'Chatbot intelligent pour aider les étudiants à trouver des informations académiques et administratives.',
                'group_id' => 5, // Groupe A - Master IA 2023
                'icon' => 'heroicon-o-chat-bubble-left',
                'image_id' => null,
            ],
            [
                'name' => 'Système de Gestion de Bibliothèque',
                'description' => 'Application web pour gérer les emprunts et retours de livres dans une bibliothèque universitaire.',
                'group_id' => 2, // Groupe B - Bachelor Info 2023
                'icon' => 'heroicon-o-document',
                'image_id' => null,
            ],
            [
                'name' => 'Plateforme de Covoiturage Campus',
                'description' => 'Application permettant aux étudiants et au personnel de partager leurs trajets domicile-campus.',
                'group_id' => 6, // Groupe A - Ingénieur 2023
                'icon' => 'heroicon-o-globe-europe-africa',
                'image_id' => null,
            ],
        ];

        foreach ($projects as $project) {
            Projects::create($project);
        }

        // // Créer quelques projets supplémentaires avec faker
        // Projects::factory()->count(10)->create();
    }
}
