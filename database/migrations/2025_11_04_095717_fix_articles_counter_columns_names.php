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
        // Verifica che la tabella articles esista prima di modificarla
        if (Schema::hasTable('articles')) {
            Schema::table('articles', function (Blueprint $table) {
                // Rinomina le colonne solo se esistono
                if (Schema::hasColumn('articles', 'likes_count') && !Schema::hasColumn('articles', 'like_count')) {
                    $table->renameColumn('likes_count', 'like_count');
                }
                if (Schema::hasColumn('articles', 'comments_count') && !Schema::hasColumn('articles', 'comment_count')) {
                    $table->renameColumn('comments_count', 'comment_count');
                }
                if (Schema::hasColumn('articles', 'views_count') && !Schema::hasColumn('articles', 'view_count')) {
                    $table->renameColumn('views_count', 'view_count');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Ripristina i nomi originali
            $table->renameColumn('like_count', 'likes_count');
            $table->renameColumn('comment_count', 'comments_count');
            $table->renameColumn('view_count', 'views_count');
        });
    }
};
