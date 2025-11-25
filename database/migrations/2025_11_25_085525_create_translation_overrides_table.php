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
        Schema::create('translation_overrides', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->index(); // it, en, fr, etc.
            $table->string('group', 50)->index(); // admin, common, auth, etc.
            $table->string('key', 255)->index(); // welcome, title, etc.
            $table->text('value')->nullable(); // Testo tradotto
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Indice unico per evitare duplicati
            $table->unique(['locale', 'group', 'key'], 'unique_translation_override');

            // Indici per performance
            $table->index(['locale', 'group']);
            $table->index(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_overrides');
    }
};
