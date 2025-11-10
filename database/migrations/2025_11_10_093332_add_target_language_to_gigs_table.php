<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gigs', function (Blueprint $table) {
            // Aggiungi target_language (singolare) per semplificare la gestione
            if (!Schema::hasColumn('gigs', 'target_language')) {
                $table->string('target_language', 10)->nullable();
            }
            
            // Aggiungi requester_id se non esiste
            if (!Schema::hasColumn('gigs', 'requester_id')) {
                $table->foreignId('requester_id')->nullable()->constrained('users')->nullOnDelete();
            }
            
            // Aggiungi requirements se non esiste (diverso da translation_instructions)
            if (!Schema::hasColumn('gigs', 'requirements')) {
                $table->text('requirements')->nullable();
            }
            
            // Aggiungi proposed_compensation se non esiste
            if (!Schema::hasColumn('gigs', 'proposed_compensation')) {
                $table->decimal('proposed_compensation', 10, 2)->nullable();
            }
            
            // Aggiungi status se non esiste
            if (!Schema::hasColumn('gigs', 'status')) {
                $table->string('status', 50)->default('open')->nullable();
            }
            
            // Aggiungi accepted_translator_id se non esiste
            if (!Schema::hasColumn('gigs', 'accepted_translator_id')) {
                $table->foreignId('accepted_translator_id')->nullable()->constrained('users')->nullOnDelete();
            }
            
            // Aggiungi accepted_at se non esiste
            if (!Schema::hasColumn('gigs', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable();
            }
            
            // Aggiungi completed_at se non esiste
            if (!Schema::hasColumn('gigs', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gigs', function (Blueprint $table) {
            if (Schema::hasColumn('gigs', 'target_language')) {
                $table->dropColumn('target_language');
            }
            if (Schema::hasColumn('gigs', 'requirements')) {
                $table->dropColumn('requirements');
            }
            if (Schema::hasColumn('gigs', 'proposed_compensation')) {
                $table->dropColumn('proposed_compensation');
            }
            if (Schema::hasColumn('gigs', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('gigs', 'accepted_translator_id')) {
                $table->dropForeign(['accepted_translator_id']);
                $table->dropColumn('accepted_translator_id');
            }
            if (Schema::hasColumn('gigs', 'accepted_at')) {
                $table->dropColumn('accepted_at');
            }
            if (Schema::hasColumn('gigs', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
        });
    }
};
