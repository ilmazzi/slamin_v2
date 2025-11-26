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
        Schema::table('messages', function (Blueprint $table) {
            $table->timestamp('delivered_at')->nullable()->after('created_at');
            $table->timestamp('read_at')->nullable()->after('delivered_at');
            $table->index(['conversation_id', 'delivered_at']);
            $table->index(['conversation_id', 'read_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['conversation_id', 'delivered_at']);
            $table->dropIndex(['conversation_id', 'read_at']);
            $table->dropColumn(['delivered_at', 'read_at']);
        });
    }
};
