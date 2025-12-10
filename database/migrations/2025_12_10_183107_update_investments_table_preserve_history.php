<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Investment;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add columns if they don't exist
        if (!Schema::hasColumn('investments', 'project_title')) {
            Schema::table('investments', function (Blueprint $table) {
                $table->string('project_title')->nullable()->after('project_id');
            });
        }
        
        if (!Schema::hasColumn('investments', 'project_image')) {
            Schema::table('investments', function (Blueprint $table) {
                $table->string('project_image')->nullable()->after('project_title');
            });
        }

        // Populate existing records with project data
        $investments = Investment::with('project')->get();
        foreach ($investments as $investment) {
            if ($investment->project && !$investment->project_title) {
                $investment->update([
                    'project_title' => $investment->project->title,
                    'project_image' => $investment->project->image,
                ]);
            }
        }

        // Check if foreign key exists
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'investments' 
            AND CONSTRAINT_TYPE = 'FOREIGN KEY' 
            AND CONSTRAINT_NAME = 'investments_project_id_foreign'
        ");

        Schema::table('investments', function (Blueprint $table) use ($foreignKeys) {
            // Drop the old foreign key constraint if it exists
            if (!empty($foreignKeys)) {
                $table->dropForeign(['project_id']);
            }
            
            // Make project_id nullable
            $table->unsignedBigInteger('project_id')->nullable()->change();
        });
        
        // Add new foreign key with nullOnDelete
        Schema::table('investments', function (Blueprint $table) {
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            // Drop the new foreign key
            $table->dropForeign(['project_id']);
            
            // Make project_id non-nullable again
            $table->unsignedBigInteger('project_id')->nullable(false)->change();
            
            // Restore the old cascade foreign key
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('cascade');
            
            // Remove the added columns
            $table->dropColumn(['project_title', 'project_image']);
        });
    }
};
