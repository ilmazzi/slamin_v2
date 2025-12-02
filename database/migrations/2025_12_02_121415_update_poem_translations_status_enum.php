<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `poem_translations` MODIFY COLUMN `status` ENUM('draft', 'submitted', 'in_review', 'approved', 'rejected', 'published', 'completed') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `poem_translations` MODIFY COLUMN `status` ENUM('draft', 'submitted', 'approved', 'rejected') DEFAULT 'draft'");
    }
};
