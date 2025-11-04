<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Poem;
use App\Models\Article;
use App\Models\Event;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Inizio seeding...');

        // 1. Crea utenti di test
        $this->command->info('👥 Creazione utenti...');
        
        // Utente admin di test
        $admin = User::firstOrCreate(
            ['email' => 'admin@slamin.test'],
            [
                'name' => 'Admin Slamin',
                'nickname' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        // Utente normale di test
        $testUser = User::firstOrCreate(
            ['email' => 'user@slamin.test'],
            [
                'name' => 'Marco Poeta',
                'nickname' => 'marcopoeta',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Altri utenti random
        $users = User::factory(12)->create();
        
        $allUsers = collect([$admin, $testUser])->merge($users);
        
        $this->command->info("✅ Creati {$allUsers->count()} utenti");

        // 2. Crea poesie
        $this->command->info('📝 Creazione poesie...');
        $poems = Poem::factory(35)->create();
        $this->command->info("✅ Create {$poems->count()} poesie");

        // 3. Crea articoli
        $this->command->info('📰 Creazione articoli...');
        $articles = Article::factory(18)->create();
        $this->command->info("✅ Creati {$articles->count()} articoli");

        // 4. Crea eventi
        $this->command->info('📅 Creazione eventi...');
        $events = Event::factory(12)->create();
        $this->command->info("✅ Creati {$events->count()} eventi");

        // 5. Crea video
        $this->command->info('🎥 Creazione video...');
        $videos = Video::factory(20)->create();
        $this->command->info("✅ Creati {$videos->count()} video");

        $this->command->info('');
        $this->command->info('🎉 SEEDING COMPLETATO!');
        $this->command->info('');
        $this->command->info('📊 Riepilogo:');
        $this->command->info("   👥 Utenti: {$allUsers->count()}");
        $this->command->info("   📝 Poesie: {$poems->count()}");
        $this->command->info("   📰 Articoli: {$articles->count()}");
        $this->command->info("   📅 Eventi: {$events->count()}");
        $this->command->info("   🎥 Video: {$videos->count()}");
        $this->command->info('');
        $this->command->info('🔑 Credenziali di test:');
        $this->command->info('   Admin: admin@slamin.test / password');
        $this->command->info('   User:  user@slamin.test / password');
    }
}

