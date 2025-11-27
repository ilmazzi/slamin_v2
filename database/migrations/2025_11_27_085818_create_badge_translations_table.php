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
        Schema::create('badge_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');
            $table->string('locale', 5); // it, en, fr, etc.
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Un badge può avere una sola traduzione per lingua
            $table->unique(['badge_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badge_translations');
    }
};
