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
        Schema::table('poem_translations', function (Blueprint $table) {
            // Add gig_application_id if not exists
            if (!Schema::hasColumn('poem_translations', 'gig_application_id')) {
                $table->foreignId('gig_application_id')->nullable()->after('gig_id')->constrained('gig_applications')->onDelete('cascade');
            }
            
            // Add version tracking
            if (!Schema::hasColumn('poem_translations', 'version')) {
                $table->integer('version')->default(1)->after('status');
            }
            
            // Add approval fields
            if (!Schema::hasColumn('poem_translations', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('completed_at');
            }
            if (!Schema::hasColumn('poem_translations', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('submitted_at');
            }
            if (!Schema::hasColumn('poem_translations', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('users')->onDelete('set null');
            }
            
            // Add translated_text alias for content
            if (!Schema::hasColumn('poem_translations', 'translated_text')) {
                $table->longText('translated_text')->nullable()->after('content');
            }
            
            // Add target_language alias for language
            if (!Schema::hasColumn('poem_translations', 'target_language')) {
                $table->string('target_language', 10)->nullable()->after('language');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('poem_translations', function (Blueprint $table) {
            if (Schema::hasColumn('poem_translations', 'gig_application_id')) {
                $table->dropForeign(['gig_application_id']);
                $table->dropColumn('gig_application_id');
            }
            if (Schema::hasColumn('poem_translations', 'version')) {
                $table->dropColumn('version');
            }
            if (Schema::hasColumn('poem_translations', 'submitted_at')) {
                $table->dropColumn('submitted_at');
            }
            if (Schema::hasColumn('poem_translations', 'approved_at')) {
                $table->dropColumn('approved_at');
            }
            if (Schema::hasColumn('poem_translations', 'approved_by')) {
                $table->dropForeign(['approved_by']);
                $table->dropColumn('approved_by');
            }
            if (Schema::hasColumn('poem_translations', 'translated_text')) {
                $table->dropColumn('translated_text');
            }
            if (Schema::hasColumn('poem_translations', 'target_language')) {
                $table->dropColumn('target_language');
            }
        });
    }
};
