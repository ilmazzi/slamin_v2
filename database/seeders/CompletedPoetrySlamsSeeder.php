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

class CompletedPoetrySlamsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🏆 Creazione Poetry Slam conclusi con podio...');

        // Get or create organizer
        $organizer = User::firstOrCreate(
            ['email' => 'organizer@slamin.test'],
            [
                'name' => 'Organizzatore Poetry Slam',
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

        // Get badges for positions
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

        // Create 3 completed Poetry Slam events
        $eventTitles = [
            'Poetry Slam Roma 2024',
            'Milano Poetry Battle',
            'Torino Slam Championship',
        ];

        $cities = ['Roma', 'Milano', 'Torino'];

        foreach ($eventTitles as $index => $title) {
            $this->command->info("📅 Creazione evento: {$title}");

            // Event date: 1-3 months ago
            $eventDate = Carbon::now()->subMonths(rand(1, 3))->subDays(rand(0, 30));
            $startDate = $eventDate->copy()->setTime(20, 0);
            $endDate = $startDate->copy()->addHours(3);

            // Create event
            $event = Event::create([
                'title' => $title,
                'subtitle' => 'Competizione di Poetry Slam',
                'description' => "Un'emozionante serata di Poetry Slam con i migliori poeti della città. Tre round di competizione con giuria popolare.",
                'category' => Event::CATEGORY_POETRY_SLAM,
                'start_datetime' => $startDate,
                'end_datetime' => $endDate,
                'venue_name' => ['Teatro Argentina', 'Caffè Letterario', 'Centro Culturale'][$index],
                'venue_address' => 'Via Roma, ' . rand(1, 100),
                'city' => $cities[$index],
                'postcode' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                'country' => 'IT',
                'is_public' => true,
                'max_participants' => 20,
                'entry_fee' => 5,
                'status' => Event::STATUS_COMPLETED,
                'moderation_status' => 'approved',
                'organizer_id' => $organizer->id,
                'like_count' => rand(20, 80),
                'comment_count' => rand(5, 25),
                'image_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1200&auto=format&fit=crop',
            ]);

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
                // Generate random score between 5 and 10
                $score = round(rand(50, 100) / 10, 1);
                
                $eventScore = EventScore::create([
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

            // Create rankings for remaining participants (positions 4+)
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

            $totalRankings = $position - 1;
            $this->command->info("✅ Evento '{$title}' creato con {$participants->count()} partecipanti e {$totalRankings} classifiche");
        }

        $this->command->info('🎉 Poetry Slam conclusi creati con successo!');
    }
}

