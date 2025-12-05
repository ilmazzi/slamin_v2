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
        Schema::table('event_invitations', function (Blueprint $table) {
            // Drop existing unique constraint
            $table->dropUnique('unique_event_invitation');
        });
        
        // Make invited_user_id nullable and add new columns
        Schema::table('event_invitations', function (Blueprint $table) {
            $table->foreignId('invited_user_id')->nullable()->change();
            $table->string('invited_email')->nullable()->after('invited_user_id');
            $table->string('invited_name')->nullable()->after('invited_email');
        });
        
        // Add unique constraints (only where not null)
        Schema::table('event_invitations', function (Blueprint $table) {
            // Unique constraint for user invitations (only when user_id is not null)
            $table->unique(['event_id', 'invited_user_id'], 'unique_event_user_invitation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_invitations', function (Blueprint $table) {
            $table->dropUnique('unique_event_user_invitation');
            $table->dropUnique('unique_event_email_invitation');
            $table->dropColumn(['invited_email', 'invited_name']);
            $table->foreignId('invited_user_id')->nullable(false)->change();
            $table->unique(['event_id', 'invited_user_id'], 'unique_event_invitation');
        });
    }
};

