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
        Schema::table('notifications', function (Blueprint $table) {
            // Add polymorphic columns for Laravel standard notifications
            if (!Schema::hasColumn('notifications', 'notifiable_type')) {
                $table->string('notifiable_type')->after('id')->default('App\\Models\\User');
            }
            
            if (!Schema::hasColumn('notifications', 'notifiable_id')) {
                $table->unsignedBigInteger('notifiable_id')->after('notifiable_type')->default(0);
            }
        });

        // Migrate existing data: copy user_id to notifiable_id
        DB::statement("UPDATE notifications SET notifiable_id = user_id, notifiable_type = 'App\\\\Models\\\\User' WHERE notifiable_id = 0");

        // Add index for polymorphic relation
        Schema::table('notifications', function (Blueprint $table) {
            if (!Schema::hasIndex('notifications', 'notifications_notifiable_type_notifiable_id_index')) {
                $table->index(['notifiable_type', 'notifiable_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['notifiable_type', 'notifiable_id']);
            $table->dropColumn(['notifiable_type', 'notifiable_id']);
        });
    }
};
