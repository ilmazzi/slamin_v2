<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Poem;
use App\Models\Gig;
use App\Models\GigApplication;
use Illuminate\Support\Str;

class TranslationGigTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crea/Trova Autore (cliente che paga)
        $author = User::firstOrCreate(
            ['email' => 'cliente@test.com'],
            [
                'name' => 'Marco Bianchi',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assegna ruolo poet se non ce l'ha
        if (!$author->hasRole('poet')) {
            $author->assignRole('poet');
        }

        // 2. Crea/Trova Traduttore
        $translator = User::firstOrCreate(
            ['email' => 'traduttore@test.com'],
            [
                'name' => 'Laura Verdi',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assegna ruolo poet se non ce l'ha
        if (!$translator->hasRole('poet')) {
            $translator->assignRole('poet');
        }

        // 3. Crea una poesia dell'autore
        $poem = Poem::firstOrCreate(
            ['slug' => 'il-vento-tra-gli-ulivi'],
            [
                'title' => 'Il Vento tra gli Ulivi',
                'content' => '<p>Soffia il vento tra gli ulivi antichi,</p>
<p>portando storie di tempi lontani.</p>
<p>Le foglie argentate danzano leggere,</p>
<p>mentre il sole tramonta sui campi.</p>
<p><br></p>
<p>Ogni ramo racconta una vita vissuta,</p>
<p>ogni frutto custodisce un segreto.</p>
<p>Il vento sussurra parole dimenticate,</p>
<p>che solo il cuore può comprendere.</p>',
                'user_id' => $author->id,
                'language' => 'it',
                'is_public' => true,
                'moderation_status' => 'approved',
                'published_at' => now(),
            ]
        );

        // 4. Crea un gig di traduzione
        $gig = Gig::firstOrCreate(
            [
                'title' => 'Traduzione Poesia in Inglese - Il Vento tra gli Ulivi',
                'user_id' => $author->id,
            ],
            [
                'description' => '<p>Cerco un traduttore esperto per tradurre la mia poesia "Il Vento tra gli Ulivi" dall\'italiano all\'inglese.</p>
<p><strong>Requisiti:</strong></p>
<ul>
<li>Esperienza in traduzione poetica</li>
<li>Sensibilità per il linguaggio metaforico</li>
<li>Rispetto del ritmo e della musicalità</li>
</ul>
<p><strong>Cosa offro:</strong></p>
<ul>
<li>Compenso equo</li>
<li>Collaborazione rispettosa</li>
<li>Possibilità di revisione insieme</li>
</ul>',
                'type' => 'translation',
                'category' => 'translation',
                'poem_id' => $poem->id,
                'compensation' => 150.00, // €150 per la traduzione
                'deadline' => now()->addDays(14),
                'is_closed' => false,
                'language' => 'en', // Target language
            ]
        );

        // 5. Crea un'application PENDING (da accettare)
        $application = GigApplication::firstOrCreate(
            [
                'gig_id' => $gig->id,
                'user_id' => $translator->id,
            ],
            [
                'message' => 'Buongiorno Marco,

Sono Laura, traduttrice professionista con 5 anni di esperienza in traduzione poetica italiano-inglese.

Ho letto con attenzione la tua poesia "Il Vento tra gli Ulivi" e mi ha profondamente colpito per la sua delicatezza e il suo legame con la natura. Credo di poter rendere giustizia alla musicalità e al significato profondo dei tuoi versi.

Nel mio portfolio ho tradotto opere di poeti contemporanei italiani per diverse riviste letterarie internazionali. Sono particolarmente attenta a preservare non solo il significato letterale, ma anche il ritmo, le metafore e l\'atmosfera emotiva del testo originale.

Sarei felice di collaborare con te su questo progetto e di lavorare insieme durante la fase di revisione per assicurarci che la traduzione rispecchi pienamente la tua visione.

Disponibilità: Posso consegnare la traduzione entro 7 giorni.
Compenso richiesto: €150 (come da tua offerta)

Resto a disposizione per qualsiasi chiarimento.

Cordiali saluti,
Laura',
                'experience' => 'Traduttrice professionista IT-EN specializzata in poesia contemporanea. Laurea in Lingue e Letterature Straniere. 5 anni di esperienza con pubblicazioni su Poetry International, The Poetry Review, e altre riviste.',
                'portfolio' => 'Portfolio disponibile su: www.lauraverdi-translations.com',
                'availability' => '7 giorni',
                'compensation_expectation' => 150.00,
                'status' => 'pending',
            ]
        );

        $this->command->info('✅ Seed completato!');
        $this->command->info('');
        $this->command->info('📧 Credenziali:');
        $this->command->info('   Autore (cliente):');
        $this->command->info('   - Email: cliente@test.com');
        $this->command->info('   - Password: password');
        $this->command->info('');
        $this->command->info('   Traduttore:');
        $this->command->info('   - Email: traduttore@test.com');
        $this->command->info('   - Password: password');
        $this->command->info('');
        $this->command->info('🎯 Flusso di Test:');
        $this->command->info('   1. Login come cliente@test.com');
        $this->command->info('   2. Vai su "I Miei Gigs"');
        $this->command->info('   3. Apri il gig "Traduzione Poesia in Inglese"');
        $this->command->info('   4. Vedi l\'application di Laura');
        $this->command->info('   5. Accetta l\'application (puoi negoziare o accettare direttamente)');
        $this->command->info('   6. Laura carica la traduzione nel workspace');
        $this->command->info('   7. Tu revisioni e approvi');
        $this->command->info('   8. Procedi al pagamento (€150 + commissioni)');
        $this->command->info('');
        $this->command->info('💰 Pagamento Atteso:');
        $this->command->info('   - Compenso traduttore: €150.00');
        $this->command->info('   - Commissione Slamin (10%): €15.00');
        $this->command->info('   - Commissione Stripe (~2.9%): €4.79');
        $this->command->info('   - TOTALE CLIENTE: €169.79');
    }
}

