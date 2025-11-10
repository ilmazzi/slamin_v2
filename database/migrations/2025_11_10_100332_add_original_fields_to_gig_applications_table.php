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
        Schema::table('gig_applications', function (Blueprint $table) {
            // Campi originali dal sistema gigs
            if (!Schema::hasColumn('gig_applications', 'message')) {
                $table->text('message')->nullable()->after('user_id');
            }
            
            if (!Schema::hasColumn('gig_applications', 'experience')) {
                $table->text('experience')->nullable()->after('message');
            }
            
            if (!Schema::hasColumn('gig_applications', 'portfolio')) {
                $table->text('portfolio')->nullable()->after('experience');
            }
            
            if (!Schema::hasColumn('gig_applications', 'portfolio_url')) {
                $table->string('portfolio_url', 500)->nullable()->after('portfolio');
            }
            
            if (!Schema::hasColumn('gig_applications', 'availability')) {
                $table->text('availability')->nullable()->after('portfolio_url');
            }
            
            if (!Schema::hasColumn('gig_applications', 'compensation_expectation')) {
                $table->text('compensation_expectation')->nullable()->after('availability');
            }
            
            // Timestamp per azioni
            if (!Schema::hasColumn('gig_applications', 'accepted_at')) {
                $table->datetime('accepted_at')->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('gig_applications', 'rejected_at')) {
                $table->datetime('rejected_at')->nullable()->after('accepted_at');
            }
            
            if (!Schema::hasColumn('gig_applications', 'withdrawn_at')) {
                $table->datetime('withdrawn_at')->nullable()->after('rejected_at');
            }
        });
        
        // Rendi nullable i campi traduzioni per retrocompatibilità
        if (Schema::hasColumn('gig_applications', 'cover_letter')) {
            DB::statement('ALTER TABLE gig_applications MODIFY cover_letter TEXT NULL');
        }
        
        if (Schema::hasColumn('gig_applications', 'proposed_compensation')) {
            DB::statement('ALTER TABLE gig_applications MODIFY proposed_compensation DECIMAL(10,2) NULL');
        }
        
        if (Schema::hasColumn('gig_applications', 'estimated_delivery')) {
            DB::statement('ALTER TABLE gig_applications MODIFY estimated_delivery DATE NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gig_applications', function (Blueprint $table) {
            $columns = [
                'message',
                'experience',
                'portfolio',
                'portfolio_url',
                'availability',
                'compensation_expectation',
                'accepted_at',
                'rejected_at',
                'withdrawn_at',
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('gig_applications', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
