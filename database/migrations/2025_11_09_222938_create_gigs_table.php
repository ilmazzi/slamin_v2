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
        if (!Schema::hasTable('gigs')) {
            Schema::create('gigs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('poem_id')->constrained()->cascadeOnDelete();
                $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
                $table->string('target_language', 10);
                $table->text('requirements')->nullable();
                $table->decimal('proposed_compensation', 10, 2);
                $table->date('deadline')->nullable();
                $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])->default('open');
                $table->foreignId('accepted_translator_id')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('accepted_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
                
                // Indexes
                $table->index(['status', 'target_language']);
                $table->index('requester_id');
                $table->index('accepted_translator_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gigs');
    }
};
