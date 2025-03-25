<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectTags = [
            [
                'project_id' => 1, // Plateforme E-learning
                'tag_id' => 1, // Web Development
            ],
            [
                'project_id' => 1, // Plateforme E-learning
                'tag_id' => 5, // Database
            ],
            [
                'project_id' => 1, // Plateforme E-learning
                'tag_id' => 6, // Frontend
            ],
            [
                'project_id' => 1, // Plateforme E-learning
                'tag_id' => 7, // Backend
            ],
            [
                'project_id' => 2, // Application Mobile de Gestion du Temps
                'tag_id' => 2, // Mobile App
            ],
            [
                'project_id' => 2, // Application Mobile de Gestion du Temps
                'tag_id' => 3, // Design
            ],
            [
                'project_id' => 2, // Application Mobile de Gestion du Temps
                'tag_id' => 9, // UI/UX
            ],
            [
                'project_id' => 3, // Système de Reconnaissance Faciale
                'tag_id' => 10, // Machine Learning
            ],
            [
                'project_id' => 3, // Système de Reconnaissance Faciale
                'tag_id' => 11, // Artificial Intelligence
            ],
            [
                'project_id' => 4, // Chatbot d'Assistance Académique
                'tag_id' => 10, // Machine Learning
            ],
            [
                'project_id' => 4, // Chatbot d'Assistance Académique
                'tag_id' => 11, // Artificial Intelligence
            ],
            [
                'project_id' => 4, // Chatbot d'Assistance Académique
                'tag_id' => 4, // API
            ],
            [
                'project_id' => 5, // Système de Gestion de Bibliothèque
                'tag_id' => 1, // Web Development
            ],
            [
                'project_id' => 5, // Système de Gestion de Bibliothèque
                'tag_id' => 5, // Database
            ],
            [
                'project_id' => 6, // Plateforme de Covoiturage Campus
                'tag_id' => 1, // Web Development
            ],
            [
                'project_id' => 6, // Plateforme de Covoiturage Campus
                'tag_id' => 2, // Mobile App
            ],
            [
                'project_id' => 6, // Plateforme de Covoiturage Campus
                'tag_id' => 3, // Design
            ],
        ];

        DB::table('projects_tags')->insert($projectTags);
    }
}
