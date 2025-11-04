<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $eventTitles = [
            'Serata Poetica sotto le Stelle',
            'Workshop di Scrittura Creativa',
            'Incontro con l\'Autore',
            'Poetry Slam Competition',
            'Lettura Poetica al Tramonto',
            'Festival della Poesia Italiana',
            'Open Mic Night',
            'Masterclass: L\'Arte dei Versi',
        ];

        $cities = ['Milano', 'Roma', 'Firenze', 'Bologna', 'Napoli', 'Torino', 'Venezia', 'Verona'];
        $city = fake()->randomElement($cities);
        
        $startDate = fake()->dateTimeBetween('now', '+90 days');
        $endDate = Carbon::instance($startDate)->addHours(fake()->numberBetween(2, 6));

        return [
            'title' => fake()->randomElement($eventTitles),
            'subtitle' => fake()->sentence(8),
            'description' => fake()->paragraphs(3, true),
            'start_datetime' => $startDate,
            'end_datetime' => $endDate,
            'registration_deadline' => Carbon::instance($startDate)->subDays(2),
            'venue_name' => fake()->randomElement(['Biblioteca Comunale', 'Teatro Verdi', 'Caffè Letterario', 'Parco Sempione', 'Centro Culturale']),
            'venue_address' => fake()->streetAddress(),
            'city' => $city,
            'postcode' => fake()->postcode(),
            'country' => 'IT',
            'is_public' => true,
            'max_participants' => fake()->numberBetween(20, 200),
            'entry_fee' => fake()->randomElement([0, 5, 10, 15, 20]),
            'status' => 'published',
            'moderation_status' => 'approved',
            'organizer_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'like_count' => fake()->numberBetween(5, 100),
            'comment_count' => fake()->numberBetween(0, 30),
            'category' => fake()->randomElement(['poetry_reading', 'workshop', 'competition', 'meetup']),
            'image_url' => 'https://images.unsplash.com/photo-' . fake()->randomElement([
                '1540575467063-178a50c2df87',
                '1523580494863-6f3031224c94',
                '1506157786151-b8491531f063',
            ]) . '?w=1200&auto=format&fit=crop',
        ];
    }
}

