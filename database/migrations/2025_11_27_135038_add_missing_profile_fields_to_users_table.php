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
        Schema::table('users', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'social_linkedin')) {
                $table->string('social_linkedin')->nullable()->after('social_twitter');
            }
            if (!Schema::hasColumn('users', 'show_email')) {
                $table->boolean('show_email')->default(false)->after('social_linkedin');
            }
            if (!Schema::hasColumn('users', 'show_phone')) {
                $table->boolean('show_phone')->default(false)->after('show_email');
            }
            if (!Schema::hasColumn('users', 'show_birth_date')) {
                $table->boolean('show_birth_date')->default(false)->after('show_phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'birth_date',
                'social_linkedin',
                'show_email',
                'show_phone',
                'show_birth_date',
            ]);
        });
    }
};
