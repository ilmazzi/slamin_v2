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
        Schema::table('helps', function (Blueprint $table) {
            if (!Schema::hasColumn('helps', 'category')) {
                $table->string('category')->nullable()->after('content');
            }
            if (!Schema::hasColumn('helps', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('is_active')->constrained('users')->onDelete('set null');
            }
        });

        // Aggiungi indici separatamente per evitare errori se già esistono
        try {
            Schema::table('helps', function (Blueprint $table) {
                $table->index(['type', 'is_active'], 'helps_type_is_active_index');
            });
        } catch (\Exception $e) {
            // Indice già esistente, ignora
        }

        try {
            Schema::table('helps', function (Blueprint $table) {
                $table->index(['category', 'is_active'], 'helps_category_is_active_index');
            });
        } catch (\Exception $e) {
            // Indice già esistente, ignora
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helps', function (Blueprint $table) {
            if (Schema::hasColumn('helps', 'created_by')) {
                $table->dropForeign(['created_by']);
            }
            if (Schema::hasColumn('helps', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('helps', 'created_by')) {
                $table->dropColumn('created_by');
            }
        });

        // Rimuovi indici se esistono
        try {
            Schema::table('helps', function (Blueprint $table) {
                $table->dropIndex('helps_type_is_active_index');
            });
        } catch (\Exception $e) {
            // Indice non esiste, ignora
        }

        try {
            Schema::table('helps', function (Blueprint $table) {
                $table->dropIndex('helps_category_is_active_index');
            });
        } catch (\Exception $e) {
            // Indice non esiste, ignora
        }
    }
};
