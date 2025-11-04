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
        $city = $this->faker->randomElement($cities);
        
        $startDate = $this->faker->dateTimeBetween('now', '+90 days');
        $endDate = Carbon::instance($startDate)->addHours($this->faker->numberBetween(2, 6));

        return [
            'title' => $this->faker->randomElement($eventTitles),
            'subtitle' => $this->faker->sentence(8),
            'description' => $this->faker->paragraphs(3, true),
            'start_datetime' => $startDate,
            'end_datetime' => $endDate,
            'registration_deadline' => Carbon::instance($startDate)->subDays(2),
            'venue_name' => $this->faker->randomElement(['Biblioteca Comunale', 'Teatro Verdi', 'Caffè Letterario', 'Parco Sempione', 'Centro Culturale']),
            'venue_address' => $this->faker->streetAddress(),
            'city' => $city,
            'postcode' => $this->faker->postcode(),
            'country' => 'IT',
            'is_public' => true,
            'max_participants' => $this->faker->numberBetween(20, 200),
            'entry_fee' => $this->faker->randomElement([0, 5, 10, 15, 20]),
            'status' => 'published',
            'moderation_status' => 'approved',
            'organizer_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'like_count' => $this->faker->numberBetween(5, 100),
            'comment_count' => $this->faker->numberBetween(0, 30),
            'category' => $this->faker->randomElement(['poetry_reading', 'workshop', 'competition', 'meetup']),
            'image_url' => 'https://images.unsplash.com/photo-' . $this->faker->randomElement([
                '1540575467063-178a50c2df87',
                '1523580494863-6f3031224c94',
                '1506157786151-b8491531f063',
            ]) . '?w=1200&auto=format&fit=crop',
        ];
    }
}

