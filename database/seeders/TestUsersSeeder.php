<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password'); // Password per tutti: "password"

        // 1. ADMIN - Ha tutti i privilegi
        User::updateOrCreate(
            ['email' => 'admin@slamin.test'],
            [
                'name' => 'Admin User',
                'password' => $password,
                'email_verified_at' => now(),
                'bio' => 'Amministratore della piattaforma',
                'location' => 'Milano, Italia',
            ]
        );

        $users = [
            ['email' => 'poeta@slamin.test', 'name' => 'Marco il Poeta', 'bio' => 'Poeta italiano appassionato di spoken word e poetry slam', 'location' => 'Roma, Italia'],
            ['email' => 'traduttrice@slamin.test', 'name' => 'Laura la Traduttrice', 'bio' => 'Traduttrice professionista specializzata in poesia italiana, francese e inglese. Oltre 10 anni di esperienza.', 'location' => 'Firenze, Italia'],
            ['email' => 'translator@slamin.test', 'name' => 'John the Translator', 'bio' => 'Professional English translator specialized in poetry and creative writing. Native English speaker living in Italy.', 'location' => 'Milan, Italy'],
            ['email' => 'organizzatore@slamin.test', 'name' => 'Giuseppe Organizzatore', 'bio' => 'Organizzatore di eventi culturali e poetry slam. Sempre alla ricerca di talenti.', 'location' => 'Napoli, Italia'],
            ['email' => 'poetesse@slamin.test', 'name' => 'Sophie la Poétesse', 'bio' => 'Poétesse française passionnée par la poésie contemporaine et le slam.', 'location' => 'Paris, France'],
            ['email' => 'poeta.es@slamin.test', 'name' => 'Carlos el Poeta', 'bio' => 'Poeta español especializado en slam y poesía urbana.', 'location' => 'Barcelona, España'],
            ['email' => 'multilingual@slamin.test', 'name' => 'Maria Multilingual', 'bio' => 'Traduttrice professionale che parla 5 lingue: IT, EN, FR, ES, DE. Specializzata in letteratura.', 'location' => 'Zurigo, Svizzera'],
            ['email' => 'aspirante@slamin.test', 'name' => 'Alessandro Aspirante', 'bio' => 'Giovane poeta alla ricerca di opportunità nel mondo del poetry slam.', 'location' => 'Torino, Italia'],
            ['email' => 'spettatore@slamin.test', 'name' => 'Luca Spettatore', 'bio' => 'Appassionato di poesia, mi piace assistere agli eventi.', 'location' => 'Bologna, Italia'],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, [
                    'password' => $password,
                    'email_verified_at' => now(),
                ])
            );
        }

        $this->command->info('✅ Creati 10 utenti di test!');
        $this->command->info('');
        $this->command->info('📧 CREDENZIALI LOGIN (password per tutti: "password"):');
        $this->command->info('');
        $this->command->table(
            ['Email', 'Nome', 'Ruolo/Tipo'],
            [
                ['admin@slamin.test', 'Admin User', '🔐 Admin (tutti i privilegi)'],
                ['poeta@slamin.test', 'Marco il Poeta', '✍️ Poeta italiano'],
                ['traduttrice@slamin.test', 'Laura la Traduttrice', '🌍 Traduttrice IT/FR/EN'],
                ['translator@slamin.test', 'John the Translator', '🇬🇧 Traduttore inglese'],
                ['organizzatore@slamin.test', 'Giuseppe Organizzatore', '🎭 Organizzatore eventi'],
                ['poetesse@slamin.test', 'Sophie la Poétesse', '🇫🇷 Poetessa francese'],
                ['poeta.es@slamin.test', 'Carlos el Poeta', '🇪🇸 Poeta spagnolo'],
                ['multilingual@slamin.test', 'Maria Multilingual', '🌐 Traduttrice multilingua'],
                ['aspirante@slamin.test', 'Alessandro Aspirante', '🆕 Aspirante poeta'],
                ['spettatore@slamin.test', 'Luca Spettatore', '👀 Spettatore'],
            ]
        );
        $this->command->info('');
        $this->command->info('💡 Usa questi utenti per testare le candidature ai gigs!');
    }
}
