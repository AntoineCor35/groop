<?php

namespace Database\Seeders;

use App\Models\Groups;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Groupe A - Bachelor Info 2023',
                'description' => 'Groupe A de la promotion Bachelor Informatique 2023',
                'promotion_id' => 1, // Bachelor Informatique 2023
                'image_id' => null,
            ],
            [
                'name' => 'Groupe B - Bachelor Info 2023',
                'description' => 'Groupe B de la promotion Bachelor Informatique 2023',
                'promotion_id' => 1, // Bachelor Informatique 2023
                'image_id' => null,
            ],
            [
                'name' => 'Challenge Top Code',
                'description' => 'À travers une trame narrative immersive, les participants relèvent des challenges techniques stimulants, seul ou en équipe. Un univers scénarisé, des missions à haut potentiel, et un seul objectif : coder pour devenir le meilleur.',
                'promotion_id' => 2, // Master Informatique 2023
                'image_id' => null,
            ],
            [
                'name' => 'English Game',
                'description' => 'Groupe B de la promotion Master Informatique 2023',
                'promotion_id' => 2, // Master Informatique 2023
                'image_id' => null,
            ],
            [
                'name' => 'My Digital Project',
                'description' => 'Conception et réalisation d’un projet digital en groupe, sur la base d’une initiative étudiante (fictive) ou d’une commande externe (réelle).',
                'promotion_id' => 2,
                'image_id' => null,
            ],
            [
                'name' => 'Groupe A - Ingénieur 2023',
                'description' => 'Groupe A de la promotion Ingénieur 2023',
                'promotion_id' => 4, // Ingénieur 2023
                'image_id' => null,
            ],
        ];

        foreach ($groups as $group) {
            Groups::create($group);
        }

        // // Créer quelques groupes supplémentaires avec faker
        // Groups::factory()->count(4)->create();
    }
}
