<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\EventParticipant;
use App\Models\EventRound;
use App\Models\EventScore;
use App\Models\EventRanking;
use App\Models\Badge;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompletedEventsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📅 Creazione eventi conclusi di tutti i tipi...');

        // Get or create organizer
        $organizer = User::firstOrCreate(
            ['email' => 'organizer@slamin.test'],
            [
                'name' => 'Organizzatore Eventi',
                'nickname' => 'organizer',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Get existing users or create some
        $users = User::where('id', '!=', $organizer->id)->take(10)->get();
        if ($users->count() < 5) {
            $users = User::factory(5)->create();
        }

        // Get badges for Poetry Slam positions
        $goldBadge = Badge::where('name', 'Campione - Oro')
            ->where('type', 'event')
            ->where('category', 'event_wins')
            ->first();
        
        $silverBadge = Badge::where('name', 'Finalista - Argento')
            ->where('type', 'event')
            ->where('category', 'event_wins')
            ->first();
        
        $bronzeBadge = Badge::where('name', 'Podio - Bronzo')
            ->where('type', 'event')
            ->where('category', 'event_wins')
            ->first();

        // Tutte le categorie di eventi
        $categories = [
            Event::CATEGORY_POETRY_SLAM,
            Event::CATEGORY_WORKSHOP,
            Event::CATEGORY_OPEN_MIC,
            Event::CATEGORY_READING,
            Event::CATEGORY_FESTIVAL,
            Event::CATEGORY_CONCERT,
            Event::CATEGORY_BOOK_PRESENTATION,
            Event::CATEGORY_CONFERENCE,
            Event::CATEGORY_CONTEST,
            Event::CATEGORY_POETRY_ART,
            Event::CATEGORY_SPOKEN_WORD,
        ];

        $eventTitles = [
            Event::CATEGORY_POETRY_SLAM => [
                'Poetry Slam Roma 2024',
                'Milano Poetry Battle',
            ],
            Event::CATEGORY_WORKSHOP => [
                'Workshop di Scrittura Creativa',
                'Laboratorio di Poesia',
            ],
            Event::CATEGORY_OPEN_MIC => [
                'Open Mic al Caffè Letterario',
                'Serata Open Mic',
            ],
            Event::CATEGORY_READING => [
                'Lettura Collettiva di Poesie',
                'Reading Poetico',
            ],
            Event::CATEGORY_FESTIVAL => [
                'Festival della Poesia',
                'Festival Letterario',
            ],
            Event::CATEGORY_CONCERT => [
                'Concerto di Poesia e Musica',
                'Poesia in Musica',
            ],
            Event::CATEGORY_BOOK_PRESENTATION => [
                'Presentazione: "Versi Liberi"',
                'Incontro con l\'Autore',
            ],
            Event::CATEGORY_CONFERENCE => [
                'Conferenza sulla Poesia Contemporanea',
                'Incontro Letterario',
            ],
            Event::CATEGORY_CONTEST => [
                'Concorso di Poesia',
                'Gara Poetica',
            ],
            Event::CATEGORY_POETRY_ART => [
                'Poesia e Arte Visiva',
                'Mostra Poetico-Artistica',
            ],
            Event::CATEGORY_SPOKEN_WORD => [
                'Spoken Word Night',
                'Serata Spoken Word',
            ],
        ];

        $cities = ['Roma', 'Milano', 'Torino', 'Firenze', 'Napoli', 'Bologna', 'Venezia'];
        $venues = [
            'Teatro Argentina', 'Caffè Letterario', 'Centro Culturale', 
            'Biblioteca Comunale', 'Auditorium', 'Sala Conferenze', 
            'Teatro Verdi', 'Spazio Culturale', 'Libreria Indipendente'
        ];

        $eventIndex = 0;
        foreach ($categories as $category) {
            $titles = $eventTitles[$category] ?? ['Evento ' . $category];
            
            foreach ($titles as $title) {
                // Event date: 1-3 days ago (per essere visibili nella sezione)
                $daysAgo = rand(1, 3);
                $eventDate = Carbon::now()->subDays($daysAgo);
                $startDate = $eventDate->copy()->setTime(20, 0);
                $endDate = $startDate->copy()->addHours(rand(2, 4));

                $city = $cities[array_rand($cities)];
                $venue = $venues[array_rand($venues)];

                // Create event
                $event = Event::create([
                    'title' => $title,
                    'subtitle' => 'Evento concluso di recente',
                    'description' => "Un evento di {$category} che si è appena concluso. " . 
                                   "Un'esperienza coinvolgente con partecipanti entusiasti e contenuti di qualità.",
                    'category' => $category,
                    'start_datetime' => $startDate,
                    'end_datetime' => $endDate,
                    'venue_name' => $venue,
                    'venue_address' => 'Via ' . $city . ', ' . rand(1, 200),
                    'city' => $city,
                    'postcode' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                    'country' => 'IT',
                    'is_public' => true,
                    'max_participants' => rand(20, 100),
                    'entry_fee' => rand(0, 1) ? rand(5, 20) : 0,
                    'status' => Event::STATUS_COMPLETED,
                    'moderation_status' => 'approved',
                    'organizer_id' => $organizer->id,
                    'like_count' => rand(10, 50),
                    'comment_count' => rand(2, 15),
                    'image_url' => 'https://images.unsplash.com/photo-' . [
                        '1540575467063-178a50c2df87',
                        '1523580494863-6f3031224c94',
                        '1506157786151-b8491531f063',
                        '1517841905240-472988babdf9',
                        '1494790108377-be9c29b29330',
                    ][array_rand([
                        '1540575467063-178a50c2df87',
                        '1523580494863-6f3031224c94',
                        '1506157786151-b8491531f063',
                        '1517841905240-472988babdf9',
                        '1494790108377-be9c29b29330',
                    ])] . '?w=1200&auto=format&fit=crop',
                ]);

                $this->command->info("📅 Creato evento: {$title} ({$category}) - {$daysAgo} giorni fa");

                // Solo per Poetry Slam, crea round, partecipanti, scores e rankings
                if ($category === Event::CATEGORY_POETRY_SLAM) {
                    // Create round
                    $round = EventRound::create([
                        'event_id' => $event->id,
                        'round_number' => 1,
                        'name' => 'Round Finale',
                        'scoring_type' => 'average',
                        'is_active' => true,
                        'order' => 1,
                    ]);

                    // Select 5-8 participants
                    $participantUsers = $users->random(rand(5, min(8, $users->count())));
                    $participants = collect();

                    foreach ($participantUsers as $user) {
                        $participant = EventParticipant::create([
                            'event_id' => $event->id,
                            'user_id' => $user->id,
                            'status' => 'performed',
                            'performance_order' => $participants->count() + 1,
                        ]);
                        $participants->push($participant);
                    }

                    // Create scores for each participant
                    $scores = [];
                    foreach ($participants as $participant) {
                        $score = round(rand(50, 100) / 10, 1);
                        
                        EventScore::create([
                            'event_id' => $event->id,
                            'participant_id' => $participant->id,
                            'round' => 1,
                            'score' => $score,
                            'scored_at' => $startDate->copy()->addHours(2),
                        ]);
                        
                        $scores[$participant->id] = $score;
                    }

                    // Sort participants by score (descending)
                    $sortedParticipants = $participants->sortByDesc(function($p) use ($scores) {
                        return $scores[$p->id] ?? 0;
                    })->values();

                    // Create rankings (top 3)
                    $top3 = $sortedParticipants->take(3);
                    $position = 1;
                    
                    foreach ($top3 as $participant) {
                        $badgeId = null;
                        if ($position === 1 && $goldBadge) {
                            $badgeId = $goldBadge->id;
                        } elseif ($position === 2 && $silverBadge) {
                            $badgeId = $silverBadge->id;
                        } elseif ($position === 3 && $bronzeBadge) {
                            $badgeId = $bronzeBadge->id;
                        }

                        EventRanking::create([
                            'event_id' => $event->id,
                            'participant_id' => $participant->id,
                            'position' => $position,
                            'total_score' => $scores[$participant->id],
                            'round_scores' => [1 => $scores[$participant->id]],
                            'badge_id' => $badgeId,
                            'badge_awarded' => true,
                        ]);

                        $this->command->info("  🥇 Posizione {$position}: {$participant->display_name} - {$scores[$participant->id]} punti");
                        $position++;
                    }

                    // Create rankings for remaining participants
                    $remaining = $sortedParticipants->skip(3);
                    foreach ($remaining as $participant) {
                        EventRanking::create([
                            'event_id' => $event->id,
                            'participant_id' => $participant->id,
                            'position' => $position,
                            'total_score' => $scores[$participant->id],
                            'round_scores' => [1 => $scores[$participant->id]],
                            'badge_id' => null,
                            'badge_awarded' => false,
                        ]);
                        $position++;
                    }
                } else {
                    // Per altri eventi, crea solo alcuni partecipanti (senza scores)
                    $participantCount = rand(3, 8);
                    $participantUsers = $users->random(min($participantCount, $users->count()));
                    
                    foreach ($participantUsers as $user) {
                        EventParticipant::create([
                            'event_id' => $event->id,
                            'user_id' => $user->id,
                            'status' => 'performed',
                            'performance_order' => rand(1, 20),
                        ]);
                    }
                    $this->command->info("  👥 {$participantUsers->count()} partecipanti");
                }
            }
        }

        $this->command->info('🎉 Eventi conclusi creati con successo!');
    }
}

