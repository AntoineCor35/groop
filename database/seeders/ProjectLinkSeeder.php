<?php

namespace Database\Seeders;

use App\Models\ProjectLinks;
use Illuminate\Database\Seeder;

class ProjectLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectLinks = [
            [
                'project_id' => 1, // Plateforme E-learning
                'url' => 'https://github.com/example/elearning-platform',
                'type' => 'github',
            ],
            [
                'project_id' => 1, // Plateforme E-learning
                'url' => 'https://elearning-platform.example.com',
                'type' => 'deployment',
            ],
            [
                'project_id' => 1, // Plateforme E-learning
                'url' => 'https://docs.example.com/elearning-platform',
                'type' => 'documentation',
            ],
            [
                'project_id' => 2, // App Mobile de Gestion du Temps
                'url' => 'https://github.com/example/time-management-app',
                'type' => 'github',
            ],
            [
                'project_id' => 3, // Système de Reconnaissance Faciale
                'url' => 'https://github.com/example/facial-recognition',
                'type' => 'github',
            ],
            [
                'project_id' => 3, // Système de Reconnaissance Faciale
                'url' => 'https://docs.example.com/facial-recognition',
                'type' => 'documentation',
            ],
            [
                'project_id' => 4, // Chatbot d'Assistance Académique
                'url' => 'https://github.com/example/academic-chatbot',
                'type' => 'github',
            ],
            [
                'project_id' => 4, // Chatbot d'Assistance Académique
                'url' => 'https://chatbot.example.com',
                'type' => 'deployment',
            ],
        ];

        // foreach ($projectLinks as $link) {
        //     ProjectLinks::create($link);
        // }
    }
}
