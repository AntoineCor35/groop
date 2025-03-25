<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ordre des seeders basé sur les dépendances entre modèles
        $this->call([
            // Base models without dependencies
            RoleSeeder::class,
            MediaSeeder::class,

            // Models with simple dependencies
            UserSeeder::class,
            EntitySeeder::class,
            TagSeeder::class,

            // Models with multiple dependencies
            PromotionSeeder::class,
            GroupSeeder::class,
            ProjectSeeder::class,

            // Models dependent on projects
            ProjectLinkSeeder::class,
            ConversationSeeder::class,
            ApplicationSeeder::class,

            // Models dependent on conversations
            CommentSeeder::class,

            // Notifications depend on users
            NotificationSeeder::class,

            // Relationships seeders
            UserRoleSeeder::class,
            UserEntitySeeder::class,
            UserPromotionSeeder::class,
            UserGroupSeeder::class,
            UserProjectSeeder::class,
            ProjectTagSeeder::class,
        ]);
    }
}
