<?php

namespace Database\Seeders;

use App\Models\Comments;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            [
                'comment' => 'Bienvenue sur le projet de plateforme e-learning. Nous allons commencer par définir les fonctionnalités principales.',
                'user_id' => 1, // Admin
                'conversation_id' => 1, // Projet Plateforme E-learning
                'pinned' => true,
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'comment' => 'Je suggère de commencer par la conception de la base de données pour les utilisateurs et les cours.',
                'user_id' => 2, // Modérateur
                'conversation_id' => 1, // Projet Plateforme E-learning
                'pinned' => false,
                'created_at' => Carbon::now()->subDays(29),
            ],
            [
                'comment' => 'J\'ai commencé à travailler sur les maquettes de l\'interface. Je les partagerai bientôt.',
                'user_id' => 3, // Utilisateur
                'conversation_id' => 1, // Projet Plateforme E-learning
                'pinned' => false,
                'created_at' => Carbon::now()->subDays(28),
            ],
            [
                'comment' => 'Journal du 01/03/2023 : Création du repository git et initialisation du projet Laravel.',
                'user_id' => 1, // Admin
                'conversation_id' => 2, // Journal Plateforme E-learning
                'pinned' => false,
                'created_at' => Carbon::now()->subDays(27),
            ],
            [
                'comment' => 'Journal du 02/03/2023 : Mise en place de la structure MVC et des migrations initiales.',
                'user_id' => 1, // Admin
                'conversation_id' => 2, // Journal Plateforme E-learning
                'pinned' => false,
                'created_at' => Carbon::now()->subDays(26),
            ],
            [
                'comment' => 'Kick-off du projet d\'application mobile de gestion du temps. Présentons-nous et partageons nos compétences.',
                'user_id' => 1, // Admin
                'conversation_id' => 3, // Projet App Mobile de Gestion du Temps
                'pinned' => true,
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'comment' => 'Je suis spécialisé en développement mobile React Native. Je peux m\'occuper du front-end.',
                'user_id' => 3, // Utilisateur
                'conversation_id' => 3, // Projet App Mobile de Gestion du Temps
                'pinned' => false,
                'created_at' => Carbon::now()->subDays(19),
            ],
            [
                'comment' => 'Journal du 10/03/2023 : Création du prototype de l\'app avec les écrans principaux.',
                'user_id' => 3, // Utilisateur
                'conversation_id' => 4, // Journal App Mobile de Gestion du Temps
                'pinned' => false,
                'created_at' => Carbon::now()->subDays(18),
            ],
            [
                'comment' => 'Premier commit pour le projet de reconnaissance faciale. J\'ai mis en place l\'environnement Python et les dépendances nécessaires.',
                'user_id' => 1, // Admin
                'conversation_id' => 5, // Projet Système de Reconnaissance Faciale
                'pinned' => false,
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'comment' => 'Lancement du projet de chatbot. Nous allons utiliser NLP et des modèles de langage pour créer un assistant virtuel efficace.',
                'user_id' => 2, // Modérateur
                'conversation_id' => 6, // Projet Chatbot d'Assistance Académique
                'pinned' => true,
                'created_at' => Carbon::now()->subDays(10),
            ],
        ];

        foreach ($comments as $comment) {
            Comments::create($comment);
        }

        // Créer quelques commentaires supplémentaires
        Comments::factory()->count(20)->create();
    }
}
