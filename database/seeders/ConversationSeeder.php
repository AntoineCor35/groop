<?php

namespace Database\Seeders;

use App\Models\Conversations;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conversations = [
            [
                'project_id' => 1, // Plateforme E-learning
                'type' => 'project',
            ],
            [
                'project_id' => 1, // Plateforme E-learning
                'type' => 'journal',
            ],
            [
                'project_id' => 2, // App Mobile de Gestion du Temps
                'type' => 'project',
            ],
            [
                'project_id' => 2, // App Mobile de Gestion du Temps
                'type' => 'journal',
            ],
            [
                'project_id' => 3, // Système de Reconnaissance Faciale
                'type' => 'project',
            ],
            [
                'project_id' => 4, // Chatbot d'Assistance Académique
                'type' => 'project',
            ],
        ];

        foreach ($conversations as $conversation) {
            Conversations::create($conversation);
        }

        // // Créer quelques conversations supplémentaires
        // Conversations::factory()->count(4)->create();
    }
}
