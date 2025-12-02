<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Poem;
use App\Models\Gig;
use App\Models\GigApplication;
use Illuminate\Database\Seeder;

class TranslationGigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create users
        $author = User::where('email', 'author@test.com')->first();
        if (!$author) {
            $author = User::create([
                'name' => 'Poeta Autore',
                'nickname' => 'autore',
                'email' => 'author@test.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $author->assignRole('poet');
        }
        
        $translator = User::where('email', 'translator@test.com')->first();
        if (!$translator) {
            $translator = User::create([
                'name' => 'Traduttore Esperto',
                'nickname' => 'translator',
                'email' => 'translator@test.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $translator->assignRole('poet');
        }
        
        // Get or create a poem
        $poem = Poem::firstOrCreate(
            ['slug' => 'la-notte-stellata'],
            [
                'user_id' => $author->id,
                'title' => 'La Notte Stellata',
                'content' => '<p>Sotto il manto della notte,</p><p>le stelle danzano silenziose,</p><p>sussurrano segreti antichi</p><p>a chi sa ascoltare.</p><p><br></p><p>Nel buio profondo,</p><p>trovo la luce dell\'anima,</p><p>un faro che guida</p><p>attraverso l\'oscurità.</p>',
                'is_public' => true,
                'published_at' => now(),
                'moderation_status' => 'approved',
            ]
        );
        
        // Get or create translation gig
        $gig = Gig::firstOrCreate(
            ['poem_id' => $poem->id, 'user_id' => $author->id],
            [
            'title' => 'Traduzione Poesia: La Notte Stellata → Inglese',
            'description' => 'Cerco un traduttore esperto per tradurre questa poesia in inglese. È importante mantenere il ritmo e la musicalità del testo originale.',
            'requirements' => 'Esperienza con traduzione poetica, ottima conoscenza dell\'inglese, sensibilità letteraria.',
            'compensation' => '€50-100 (da concordare)',
            'deadline' => now()->addDays(14),
            'category' => 'translation',
            'type' => 'translation',
            'gig_type' => 'translation',
            'language' => 'it',
            'target_language' => 'en',
            'location' => 'Remoto',
            'is_remote' => true,
            'is_urgent' => false,
            'is_featured' => false,
            'is_closed' => false,
            'max_applications' => 5,
            'user_id' => $author->id,
            'requester_id' => $author->id,
            'poem_id' => $poem->id,
            'status' => 'open',
            ]
        );
        
        // Get or create application
        $application = GigApplication::firstOrCreate(
            ['gig_id' => $gig->id, 'user_id' => $translator->id],
            [
            'gig_id' => $gig->id,
            'user_id' => $translator->id,
            'message' => 'Sono un traduttore professionista con 5 anni di esperienza in traduzione poetica. Ho tradotto opere di Dante e Petrarca in inglese.',
            'experience' => 'Traduttore freelance dal 2018, specializzato in poesia italiana.',
            'portfolio' => 'Portfolio disponibile su richiesta',
            'portfolio_url' => 'https://example.com/portfolio',
            'availability' => 'Disponibile immediatamente',
            'compensation_expectation' => '75.00',
            'proposed_compensation' => 75.00,
            'status' => 'pending',
            ]
        );
        
        $this->command->info('✅ Created translation gig seeder data:');
        $this->command->info("   Author: {$author->email} (password: password)");
        $this->command->info("   Translator: {$translator->email} (password: password)");
        $this->command->info("   Poem: {$poem->title}");
        $this->command->info("   Gig: {$gig->title}");
        $this->command->info("   Application: Pending");
        $this->command->info('');
        $this->command->info('📝 Next steps:');
        $this->command->info('   1. Login as author@test.com');
        $this->command->info('   2. Go to gig and accept application');
        $this->command->info('   3. Login as translator@test.com');
        $this->command->info('   4. Access workspace and start translating');
    }
}
