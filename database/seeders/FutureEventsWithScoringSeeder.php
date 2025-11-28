<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\EventParticipant;
use App\Models\EventRound;
use App\Models\EventScore;
use App\Models\EventInvitation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FutureEventsWithScoringSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📅 Creazione eventi futuri con scoring...');

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
        $users = User::where('id', '!=', $organizer->id)->take(15)->get();
        if ($users->count() < 10) {
            $users = User::factory(10)->create();
        }

        // Create 3 future Poetry Slam events
        $eventTitles = [
            'Poetry Slam Roma 2025',
            'Milano Poetry Battle',
            'Torino Poetry Contest',
        ];

        $cities = ['Roma', 'Milano', 'Torino'];
        $venues = [
            'Teatro Verdi',
            'Caffè Letterario',
            'Centro Culturale',
        ];

        foreach ($eventTitles as $index => $title) {
            $startDate = Carbon::now()->addDays(rand(7, 30))->setTime(20, 0);
            $endDate = $startDate->copy()->addHours(3);

            $event = Event::create([
                'title' => $title,
                'subtitle' => 'Competizione di poesia performativa',
                'description' => 'Un evento emozionante dove i poeti si sfidano in una competizione di poesia performativa. I partecipanti presenteranno le loro opere e verranno giudicati da una giuria esperta.',
                'start_datetime' => $startDate,
                'end_datetime' => $endDate,
                'registration_deadline' => $startDate->copy()->subDays(1),
                'venue_name' => $venues[$index],
                'venue_address' => 'Via ' . fake()->streetName() . ', ' . rand(1, 100),
                'city' => $cities[$index],
                'postcode' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                'country' => 'IT',
                'is_public' => true,
                'max_participants' => 20,
                'entry_fee' => rand(0, 15),
                'status' => Event::STATUS_PUBLISHED,
                'moderation_status' => 'approved',
                'organizer_id' => $organizer->id,
                'category' => Event::CATEGORY_POETRY_SLAM,
                'like_count' => rand(5, 50),
                'comment_count' => rand(0, 20),
            ]);

            $this->command->info("✅ Creato evento: {$event->title}");

            // Add participants (mix of registered users and guests)
            $participantsCount = rand(8, 15);
            $selectedUsers = $users->random(min($participantsCount, $users->count()));
            $participants = collect();

            // Registered users
            foreach ($selectedUsers as $user) {
                $participant = EventParticipant::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'registration_type' => 'organizer_added',
                    'status' => 'confirmed',
                    'performance_order' => null, // Will be set later
                    'added_by' => $organizer->id,
                ]);
                $participants->push($participant);

                // Create invitation for registered users
                EventInvitation::create([
                    'event_id' => $event->id,
                    'invited_user_id' => $user->id,
                    'inviter_id' => $organizer->id,
                    'role' => 'performer',
                    'status' => 'accepted',
                ]);
            }

            // Add some guest participants
            $guestCount = rand(2, 5);
            for ($i = 0; $i < $guestCount; $i++) {
                $participant = EventParticipant::create([
                    'event_id' => $event->id,
                    'user_id' => null,
                    'guest_name' => 'Ospite ' . ($i + 1),
                    'guest_email' => 'guest' . ($i + 1) . '@example.com',
                    'registration_type' => 'guest',
                    'status' => 'confirmed',
                    'performance_order' => null,
                    'added_by' => $organizer->id,
                ]);
                $participants->push($participant);
            }

            // Set performance order
            $participants = $participants->shuffle();
            foreach ($participants as $order => $participant) {
                $participant->update(['performance_order' => $order + 1]);
            }

            $this->command->info("  📝 Aggiunti {$participants->count()} partecipanti");

            // Create rounds (1-3 rounds)
            $roundsCount = rand(1, 3);
            $roundNames = [
                1 => ['Primo Turno', 'Turno Eliminatorio', 'Qualifiche'],
                2 => ['Semifinale', 'Secondo Turno', 'Turno Intermedio'],
                3 => ['Finale', 'Terzo Turno', 'Gran Finale'],
            ];

            $rounds = collect();
            for ($roundNum = 1; $roundNum <= $roundsCount; $roundNum++) {
                $roundName = $roundNames[$roundNum][rand(0, count($roundNames[$roundNum]) - 1)];
                
                $round = EventRound::create([
                    'event_id' => $event->id,
                    'round_number' => $roundNum,
                    'name' => $roundName,
                    'scoring_type' => $roundNum === 1 ? 'average' : (rand(0, 1) ? 'average' : 'sum'),
                    'is_active' => true,
                    'order' => $roundNum,
                    'selected_participants' => $roundNum === 1 ? $participants->pluck('id')->toArray() : null,
                ]);
                $rounds->push($round);

                $this->command->info("  🎯 Creato turno: {$round->name}");
            }

            // Optionally add some scores for the first round (to test the system)
            if ($rounds->count() > 0 && rand(0, 1)) {
                $firstRound = $rounds->first();
                $judges = User::where('id', '!=', $organizer->id)->take(3)->get();
                
                if ($judges->count() > 0) {
                    foreach ($participants->take(rand(3, $participants->count())) as $participant) {
                        foreach ($judges as $judge) {
                            EventScore::create([
                                'event_id' => $event->id,
                                'participant_id' => $participant->id,
                                'judge_id' => $judge->id,
                                'round' => $firstRound->round_number,
                                'score' => round(rand(50, 100) / 10, 1), // Random score between 5.0 and 10.0
                                'scored_at' => now(),
                            ]);
                        }
                    }
                    $this->command->info("  ⭐ Aggiunti alcuni punteggi per il primo turno");
                }
            }
        }

        $this->command->info('✅ Seeding completato!');
    }
}
