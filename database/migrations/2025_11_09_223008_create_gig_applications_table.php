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
        if (!Schema::hasTable('gig_applications')) {
            Schema::create('gig_applications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('gig_id')->constrained()->cascadeOnDelete();
                $table->foreignId('translator_id')->constrained('users')->cascadeOnDelete();
                $table->text('cover_letter')->nullable();
                $table->decimal('proposed_compensation', 10, 2)->nullable();
                $table->date('estimated_delivery')->nullable();
                $table->enum('status', ['pending', 'accepted', 'rejected', 'withdrawn'])->default('pending');
                $table->text('rejection_reason')->nullable();
                $table->timestamps();
                
                // Indexes
                $table->index(['gig_id', 'status']);
                $table->index('translator_id');
                $table->unique(['gig_id', 'translator_id']); // Un traduttore può candidarsi una sola volta per gig
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gig_applications');
    }
};
