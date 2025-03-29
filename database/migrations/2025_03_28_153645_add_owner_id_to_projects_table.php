<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Projects;
use App\Models\Applications;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('owner_id')->nullable()->after('id')->constrained('users');
        });

        // Attribuer les propriétaires pour les projets existants
        $projects = Projects::all();
        foreach ($projects as $project) {
            // Première tentative : chercher l'utilisateur avec une candidature "approved" la plus ancienne
            $firstApproved = Applications::where('project_id', $project->id)
                ->where('status', 'approved')
                ->orderBy('created_at', 'asc')
                ->first();

            if ($firstApproved && User::find($firstApproved->user_id)) {
                $project->owner_id = $firstApproved->user_id;
                $project->save();
                continue;
            }

            // Deuxième tentative : prendre le premier utilisateur membre du projet
            $firstUser = DB::table('projects_user')
                ->where('project_id', $project->id)
                ->first();

            if ($firstUser && User::find($firstUser->user_id)) {
                $project->owner_id = $firstUser->user_id;
                $project->save();
                continue;
            }

            // Troisième tentative : chercher l'utilisateur admin
            $admin = User::where('role', 'Admin')->first();
            if ($admin) {
                $project->owner_id = $admin->id;
                $project->save();
                continue;
            }

            // Si aucun administrateur n'est trouvé, prendre le premier utilisateur du système
            $anyUser = User::first();
            if ($anyUser) {
                $project->owner_id = $anyUser->id;
                $project->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');
        });
    }
};
