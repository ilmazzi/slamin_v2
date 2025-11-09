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
            // Aggiungi colonne se non esistono già (senza after per compatibilità)
            if (!Schema::hasColumn('gigs', 'poem_id')) {
                $table->foreignId('poem_id')->nullable()->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('gigs', 'requester_id')) {
                $table->foreignId('requester_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('gigs', 'target_language')) {
                $table->string('target_language', 10)->nullable();
            }
            if (!Schema::hasColumn('gigs', 'requirements')) {
                $table->text('requirements')->nullable();
            }
            if (!Schema::hasColumn('gigs', 'proposed_compensation')) {
                $table->decimal('proposed_compensation', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('gigs', 'accepted_translator_id')) {
                $table->foreignId('accepted_translator_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('gigs', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable();
            }
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
            $table->dropColumn([
                'target_language',
                'requirements',
                'proposed_compensation',
                'accepted_translator_id',
                'accepted_at',
                'completed_at',
            ]);
        });
    }
};
