<?php

namespace App\Console\Commands;

use App\Models\Projects;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class TestProjectImageEditor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-project-image-editor {project_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test l\'édition d\'images pour un projet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $projectId = $this->argument('project_id');

        // Si aucun ID n'est fourni, prendre le premier projet
        if (!$projectId) {
            $project = Projects::first();
            if (!$project) {
                $this->error('Aucun projet trouvé dans la base de données.');
                return 1;
            }
        } else {
            $project = Projects::find($projectId);
            if (!$project) {
                $this->error("Projet avec ID {$projectId} non trouvé.");
                return 1;
            }
        }

        $this->info("Test d'édition d'image pour le projet: {$project->name} (ID: {$project->id})");

        // Vérifier les images actuelles
        $coverMedia = $project->getMedia('cover');
        $this->info("Images de couverture actuelles: " . $coverMedia->count());

        foreach ($coverMedia as $media) {
            $this->line(" - {$media->file_name} (ID: {$media->id})");
        }

        // Créer un fichier temporaire
        $tempFile = tempnam(sys_get_temp_dir(), 'test_image_');
        $tempPath = $tempFile . '.jpg';
        rename($tempFile, $tempPath);

        // Copier une image existante si disponible, sinon créer une image simple
        if (File::exists('public/images/placeholder.png')) {
            File::copy('public/images/placeholder.png', $tempPath);
            $this->info("Utilisation de l'image placeholder.png existante");
        } else {
            // Créer une image simple
            $im = imagecreatetruecolor(300, 200);
            $text_color = imagecolorallocate($im, 233, 14, 91);
            imagestring($im, 5, 60, 90, "Test Image", $text_color);
            imagejpeg($im, $tempPath);
            imagedestroy($im);
            $this->info("Image de test créée");
        }

        // Simuler l'upload d'un fichier
        $this->info("Tentative d'ajout d'une nouvelle image de couverture...");

        try {
            // Nettoyer la collection existante de manière sécurisée
            $project->clearCoverMediaCollection();

            // Ajouter la nouvelle image
            $project->addMedia($tempPath)
                ->toMediaCollection('cover');

            $this->info("Image ajoutée avec succès!");
        } catch (\Exception $e) {
            $this->error("Erreur lors de l'ajout de l'image: " . $e->getMessage());
            return 1;
        }

        // Vérifier que l'image a été ajoutée
        $newCoverMedia = $project->getMedia('cover');
        $this->info("Images de couverture après ajout: " . $newCoverMedia->count());

        foreach ($newCoverMedia as $media) {
            $this->line(" - {$media->file_name} (ID: {$media->id}, URL: {$media->getUrl()})");

            // Vérifier les conversions
            $this->line("   Conversions disponibles:");
            $this->line("   - thumb: " . ($media->hasGeneratedConversion('thumb') ? "Oui - " . $media->getUrl('thumb') : "Non"));
            $this->line("   - preview: " . ($media->hasGeneratedConversion('preview') ? "Oui - " . $media->getUrl('preview') : "Non"));
        }

        $this->info("Test terminé avec succès!");

        return 0;
    }
}
