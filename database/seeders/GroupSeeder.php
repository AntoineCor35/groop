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
                'name' => 'Groupe A - Master Info 2023',
                'description' => 'Groupe A de la promotion Master Informatique 2023',
                'promotion_id' => 2, // Master Informatique 2023
                'image_id' => null,
            ],
            [
                'name' => 'Groupe B - Master Info 2023',
                'description' => 'Groupe B de la promotion Master Informatique 2023',
                'promotion_id' => 2, // Master Informatique 2023
                'image_id' => null,
            ],
            [
                'name' => 'Groupe A - Master IA 2023',
                'description' => 'Groupe A de la promotion Master IA 2023',
                'promotion_id' => 3, // Master IA 2023
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

        // Créer quelques groupes supplémentaires avec faker
        Groups::factory()->count(4)->create();
    }
}
