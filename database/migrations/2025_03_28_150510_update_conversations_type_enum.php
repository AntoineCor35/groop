<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modification de l'ENUM pour accepter 'public' et 'admin'
        DB::statement("ALTER TABLE conversations MODIFY COLUMN type ENUM('journal', 'project', 'public', 'admin')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Retour à l'ENUM original
        DB::statement("ALTER TABLE conversations MODIFY COLUMN type ENUM('journal', 'project')");
    }
};
