<?php

namespace Database\Seeders;

use App\Models\Tags;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Web Development'],
            ['name' => 'Mobile App'],
            ['name' => 'Design'],
            ['name' => 'API'],
            ['name' => 'Database'],
            ['name' => 'Frontend'],
            ['name' => 'Backend'],
            ['name' => 'DevOps'],
            ['name' => 'UI/UX'],
            ['name' => 'Machine Learning'],
            ['name' => 'Artificial Intelligence'],
            ['name' => 'Big Data'],
            ['name' => 'Cloud Computing'],
            ['name' => 'IoT'],
            ['name' => 'Security'],
        ];

        foreach ($tags as $tag) {
            Tags::create($tag);
        }
    }
}
