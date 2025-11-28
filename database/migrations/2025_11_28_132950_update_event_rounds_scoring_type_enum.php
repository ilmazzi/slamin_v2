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
        // Update enum to include trimmed_mean
        DB::statement("ALTER TABLE event_rounds MODIFY COLUMN scoring_type ENUM('average', 'sum', 'best_of', 'trimmed_mean', 'elimination') DEFAULT 'average'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum
        DB::statement("ALTER TABLE event_rounds MODIFY COLUMN scoring_type ENUM('average', 'sum', 'best_of', 'elimination') DEFAULT 'average'");
    }
};

