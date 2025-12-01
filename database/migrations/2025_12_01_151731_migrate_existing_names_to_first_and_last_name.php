<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migra i dati esistenti: divide 'name' in 'first_name' e 'last_name'
        DB::table('users')
            ->whereNull('first_name')
            ->whereNotNull('name')
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $nameParts = explode(' ', trim($user->name), 2);
                    $firstName = $nameParts[0] ?? '';
                    $lastName = $nameParts[1] ?? '';
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'first_name' => $firstName,
                            'last_name' => $lastName ?: null,
                        ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ricostruisce 'name' da 'first_name' e 'last_name'
        DB::table('users')
            ->whereNotNull('first_name')
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                    
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'name' => $fullName ?: $user->first_name,
                        ]);
                }
            });
    }
};
