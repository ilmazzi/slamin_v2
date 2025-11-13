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
        // Verifica se la colonna status esiste
        if (!Schema::hasColumn('gigs', 'status')) {
            Schema::table('gigs', function (Blueprint $table) {
                $table->string('status', 50)->default('open')->nullable()->after('is_closed');
            });
            
            // Imposta status 'open' per tutti i gig non chiusi
            DB::table('gigs')
                ->where('is_closed', false)
                ->update(['status' => 'open']);
            
            // Imposta status 'closed' per tutti i gig chiusi
            DB::table('gigs')
                ->where('is_closed', true)
                ->update(['status' => 'closed']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('gigs', 'status')) {
            Schema::table('gigs', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
