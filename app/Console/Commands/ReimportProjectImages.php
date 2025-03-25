<?php

namespace App\Console\Commands;

use App\Models\Projects;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ReimportProjectImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reimport-project-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Réimporte les images de projets qui existent dans le stockage mais ne sont pas correctement liées aux projets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de la réimportation des images de projets...');

        // Récupérer tous les projets
        $projects = Projects::all();
        $this->info('Projets trouvés: ' . $projects->count());

        // Récupérer toutes les images dans le répertoire des couvertures
        $coverFiles = Storage::disk('public')->files('projects/covers');
        $this->info('Images trouvées: ' . count($coverFiles));

        if (count($coverFiles) === 0) {
            $this->warn('Aucune image trouvée dans storage/app/public/projects/covers/');
            return;
        }

        // Pour chaque projet, essayer d'associer une image
        $projectsWithImages = 0;
        $imagesAssociated = 0;

        foreach ($projects as $index => $project) {
            // Vérifier si le projet a déjà des médias associés
            $existingMedia = $project->getMedia('cover');

            if ($existingMedia->isNotEmpty()) {
                $this->info("Le projet #{$project->id} ({$project->name}) a déjà {$existingMedia->count()} image(s) associée(s).");
                $projectsWithImages++;
                continue;
            }

            // Si aucune image n'est associée, prendre la première image disponible
            if (!empty($coverFiles)) {
                $imageFile = array_shift($coverFiles);

                $this->info("Association de l'image {$imageFile} au projet #{$project->id} ({$project->name})");

                try {
                    // Nettoyer la collection au cas où
                    $project->clearMediaCollection('cover');

                    // Ajouter l'image à la collection "cover"
                    $project->addMediaFromDisk($imageFile, 'public')
                        ->toMediaCollection('cover');

                    $imagesAssociated++;
                    $projectsWithImages++;

                    $this->info("Image associée avec succès.");
                } catch (\Exception $e) {
                    $this->error("Erreur lors de l'association de l'image au projet #{$project->id}: " . $e->getMessage());
                }
            } else {
                $this->warn("Plus d'images disponibles pour le projet #{$project->id} ({$project->name})");
                break;
            }
        }

        $this->info("Réimportation terminée.");
        $this->info("Projets avec images: {$projectsWithImages} / {$projects->count()}");
        $this->info("Images associées: {$imagesAssociated}");
    }
}
