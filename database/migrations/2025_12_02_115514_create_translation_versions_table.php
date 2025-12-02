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
        Schema::create('translation_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poem_translation_id')->constrained('poem_translations')->onDelete('cascade');
            $table->foreignId('modified_by')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->integer('version_number');
            $table->text('changes_summary')->nullable();
            $table->json('diff_data')->nullable(); // Store text diff
            $table->timestamps();
            
            $table->index(['poem_translation_id', 'version_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_versions');
    }
};
