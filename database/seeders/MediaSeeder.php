<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer quelques exemples de médias
        $medias = [
            [
                'model_type' => 'App\\Models\\User',
                'model_id' => 1, // Sera associé au premier utilisateur
                'uuid' => \Illuminate\Support\Str::uuid(),
                'collection_name' => 'avatars',
                'name' => 'avatar-admin',
                'file_name' => 'admin-avatar.jpg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 5000,
                'manipulations' => json_encode([]),
                'custom_properties' => json_encode(['alt' => 'Avatar administrateur']),
                'generated_conversions' => json_encode(['thumb' => true]),
                'responsive_images' => json_encode([]),
                'order_column' => 1,
            ],
            [
                'model_type' => 'App\\Models\\Entities',
                'model_id' => 1, // Sera associé à la première entité
                'uuid' => \Illuminate\Support\Str::uuid(),
                'collection_name' => 'entity_images',
                'name' => 'logo-entite',
                'file_name' => 'entity-logo.png',
                'mime_type' => 'image/png',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 7500,
                'manipulations' => json_encode([]),
                'custom_properties' => json_encode(['alt' => 'Logo de l\'entité']),
                'generated_conversions' => json_encode(['thumb' => true]),
                'responsive_images' => json_encode([]),
                'order_column' => 2,
            ],
            [
                'model_type' => 'App\\Models\\Projects',
                'model_id' => 1, // Sera associé au premier projet
                'uuid' => \Illuminate\Support\Str::uuid(),
                'collection_name' => 'project_images',
                'name' => 'couverture-projet',
                'file_name' => 'project-cover.jpg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 10000,
                'manipulations' => json_encode([]),
                'custom_properties' => json_encode(['alt' => 'Image de couverture du projet']),
                'generated_conversions' => json_encode(['thumb' => true, 'banner' => true]),
                'responsive_images' => json_encode([]),
                'order_column' => 3,
            ],
        ];

        // S'assurer que le répertoire de stockage existe
        if (!Storage::disk('public')->exists('avatars')) {
            Storage::disk('public')->makeDirectory('avatars');
        }
        if (!Storage::disk('public')->exists('entity_images')) {
            Storage::disk('public')->makeDirectory('entity_images');
        }
        if (!Storage::disk('public')->exists('project_images')) {
            Storage::disk('public')->makeDirectory('project_images');
        }

        foreach ($medias as $media) {
            Media::create($media);
        }
    }
}
