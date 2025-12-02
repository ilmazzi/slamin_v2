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
        Schema::table('gig_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('gig_applications', 'compensation_notes')) {
                $table->text('compensation_notes')->nullable()->after('compensation_expectation');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gig_applications', function (Blueprint $table) {
            if (Schema::hasColumn('gig_applications', 'compensation_notes')) {
                $table->dropColumn('compensation_notes');
            }
        });
    }
};
