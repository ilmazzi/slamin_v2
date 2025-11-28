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
        Schema::table('event_rounds', function (Blueprint $table) {
            $table->integer('judges_count')->default(5)->after('scoring_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_rounds', function (Blueprint $table) {
            $table->dropColumn('judges_count');
        });
    }
};
