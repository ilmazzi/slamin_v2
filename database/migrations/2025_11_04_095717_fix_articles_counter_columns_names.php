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
        Schema::table('articles', function (Blueprint $table) {
            // Rinomina le colonne per uniformarle con le altre tabelle
            $table->renameColumn('likes_count', 'like_count');
            $table->renameColumn('comments_count', 'comment_count');
            $table->renameColumn('views_count', 'view_count');
        });
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
