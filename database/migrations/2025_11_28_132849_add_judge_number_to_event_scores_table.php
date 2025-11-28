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
        Schema::table('event_scores', function (Blueprint $table) {
            $table->integer('judge_number')->nullable()->after('judge_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_scores', function (Blueprint $table) {
            $table->dropColumn('judge_number');
        });
    }
};

