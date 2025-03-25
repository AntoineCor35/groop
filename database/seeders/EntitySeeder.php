<?php

namespace Database\Seeders;

use App\Models\Entities;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = [
            [
                'name' => 'Université Paris-Saclay',
                'description' => 'Université de recherche française située principalement sur le plateau de Saclay et dans les communes environnantes.',
                'image_id' => 2, // Référence au media créé dans MediaSeeder
            ],
            [
                'name' => 'École Polytechnique',
                'description' => 'École d\'ingénieurs française créée en 1794, membre fondateur de l\'Institut polytechnique de Paris.',
                'image_id' => null,
            ],
            [
                'name' => 'CentraleSupélec',
                'description' => 'École d\'ingénieurs française issue de la fusion en 2015 de l\'École centrale Paris et de Supélec.',
                'image_id' => null,
            ],
            [
                'name' => 'ISEP',
                'description' => 'Institut supérieur d\'électronique de Paris, est une école d\'ingénieurs française.',
                'image_id' => null,
            ],
        ];

        foreach ($entities as $entity) {
            Entities::create($entity);
        }

        // Créer quelques entités supplémentaires avec faker
        Entities::factory()->count(3)->create();
    }
}
