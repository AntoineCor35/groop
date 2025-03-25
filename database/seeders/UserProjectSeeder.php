<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userProjects = [
            [
                'user_id' => 1, // Admin
                'project_id' => 1, // Plateforme E-learning
            ],
            [
                'user_id' => 1, // Admin
                'project_id' => 3, // Système de Reconnaissance Faciale
            ],
            [
                'user_id' => 2, // Modérateur
                'project_id' => 1, // Plateforme E-learning
            ],
            [
                'user_id' => 2, // Modérateur
                'project_id' => 4, // Chatbot d'Assistance Académique
            ],
            [
                'user_id' => 3, // Utilisateur
                'project_id' => 1, // Plateforme E-learning
            ],
            [
                'user_id' => 3, // Utilisateur
                'project_id' => 2, // Application Mobile de Gestion du Temps
            ],
            [
                'user_id' => 5,
                'project_id' => 4, // Chatbot d'Assistance Académique
            ],
            [
                'user_id' => 6,
                'project_id' => 3, // Système de Reconnaissance Faciale
            ],
            [
                'user_id' => 7,
                'project_id' => 2, // Application Mobile de Gestion du Temps
            ],
            [
                'user_id' => 8,
                'project_id' => 6, // Plateforme de Covoiturage Campus
            ],
            [
                'user_id' => 9,
                'project_id' => 6, // Plateforme de Covoiturage Campus
            ],
            [
                'user_id' => 10,
                'project_id' => 5, // Système de Gestion de Bibliothèque
            ],
        ];

        DB::table('projects_user')->insert($userProjects);
    }
}
