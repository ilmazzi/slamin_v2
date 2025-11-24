<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Amministratore',
                'description' => 'Amministratore del sistema con accesso completo',
                'guard_name' => 'web',
            ],
            [
                'name' => 'poet',
                'display_name' => 'Poeta',
                'description' => 'Poeta che può pubblicare poesie e partecipare agli eventi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'organizer',
                'display_name' => 'Organizzatore',
                'description' => 'Organizzatore di eventi Poetry Slam',
                'guard_name' => 'web',
            ],
            [
                'name' => 'judge',
                'display_name' => 'Giudice',
                'description' => 'Giudice per gli eventi Poetry Slam',
                'guard_name' => 'web',
            ],
            [
                'name' => 'venue_owner',
                'display_name' => 'Proprietario Locale',
                'description' => 'Proprietario di un locale per eventi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'technician',
                'display_name' => 'Tecnico',
                'description' => 'Tecnico per eventi',
                'guard_name' => 'web',
            ],
            [
                'name' => 'audience',
                'display_name' => 'Pubblico',
                'description' => 'Membro del pubblico',
                'guard_name' => 'web',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );
        }
    }
}

