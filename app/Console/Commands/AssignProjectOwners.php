<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Projects;
use App\Models\Applications;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AssignProjectOwners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:assign-owners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigne des propriétaires aux projets qui n\'en ont pas encore';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $projects = Projects::whereNull('owner_id')->get();
        $this->info("Nombre de projets sans propriétaire : " . $projects->count());

        foreach ($projects as $project) {
            $this->info("Traitement du projet #{$project->id} : {$project->name}");

            // Première tentative : chercher l'utilisateur avec une candidature "approved" la plus ancienne
            $firstApproved = Applications::where('project_id', $project->id)
                ->where('status', 'approved')
                ->orderBy('created_at', 'asc')
                ->first();

            if ($firstApproved && User::find($firstApproved->user_id)) {
                $project->owner_id = $firstApproved->user_id;
                $project->save();
                $this->info("Propriétaire assigné : utilisateur #{$firstApproved->user_id} (via candidature approuvée)");
                continue;
            }

            // Deuxième tentative : prendre le premier utilisateur membre du projet
            $firstUser = DB::table('projects_user')
                ->where('project_id', $project->id)
                ->first();

            if ($firstUser && User::find($firstUser->user_id)) {
                $project->owner_id = $firstUser->user_id;
                $project->save();
                $this->info("Propriétaire assigné : utilisateur #{$firstUser->user_id} (membre du projet)");
                continue;
            }

            // Troisième tentative : chercher l'utilisateur admin
            $admin = User::where('role', 'Admin')->first();
            if ($admin) {
                $project->owner_id = $admin->id;
                $project->save();
                $this->info("Propriétaire assigné : administrateur #{$admin->id}");
                continue;
            }

            // Si aucun administrateur n'est trouvé, prendre le premier utilisateur du système
            $anyUser = User::first();
            if ($anyUser) {
                $project->owner_id = $anyUser->id;
                $project->save();
                $this->info("Propriétaire assigné : utilisateur par défaut #{$anyUser->id}");
            } else {
                $this->error("Impossible d'assigner un propriétaire au projet #{$project->id}");
            }
        }

        $this->info("Opération terminée.");
    }
}
