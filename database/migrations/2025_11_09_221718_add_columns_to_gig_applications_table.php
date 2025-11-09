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
        Schema::table('gig_applications', function (Blueprint $table) {
            // Aggiungi colonne se non esistono già
            if (!Schema::hasColumn('gig_applications', 'cover_letter')) {
                $table->text('cover_letter')->nullable();
            }
            if (!Schema::hasColumn('gig_applications', 'proposed_compensation')) {
                $table->decimal('proposed_compensation', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('gig_applications', 'estimated_delivery')) {
                $table->date('estimated_delivery')->nullable();
            }
            if (!Schema::hasColumn('gig_applications', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gig_applications', function (Blueprint $table) {
            $table->dropColumn([
                'cover_letter',
                'proposed_compensation',
                'estimated_delivery',
                'rejection_reason',
            ]);
        });
    }
};
