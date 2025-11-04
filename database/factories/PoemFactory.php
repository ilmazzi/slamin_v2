<?php

namespace Database\Factories;

use App\Models\Poem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PoemFactory extends Factory
{
    protected $model = Poem::class;

    public function definition(): array
    {
        $poemTitles = [
            'Sussurri del Vento',
            'Alba Dorata',
            'Notte Stellata',
            'Il Silenzio Parla',
            'Tra le Nuvole',
            'Eco del Mare',
            'Ricordi d\'Autunno',
            'Primavera Nascente',
            'Ombre e Luce',
            'L\'Ultimo Petalo',
        ];

        $poemContents = [
            "Nel silenzio della notte\nil vento parla,\nracconta storie\ndi terre lontane\ne cuori dimenticati.\n\nOgni respiro\nè una poesia,\nogni battito\nun verso d'amore.",
            "Quando il sole bacia l'orizzonte,\ndipinge il cielo\ndi mille colori.\n\nOro, rosa, viola,\nsfumature di sogni\nche danzano\nnel crepuscolo.",
            "Le stelle brillano\ncome lacrime di gioia,\nnel manto nero\ndella notte infinita.\n\nOgni stella\nun desiderio,\nogni desiderio\nuna speranza.",
        ];

        $title = $this->faker->randomElement($poemTitles) . ' ' . Str::random(5);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'content' => $this->faker->randomElement($poemContents),
            'description' => $this->faker->sentence(10),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'is_public' => true,
            'moderation_status' => 'approved',
            'view_count' => $this->faker->numberBetween(50, 2000),
            'like_count' => $this->faker->numberBetween(10, 300),
            'comment_count' => $this->faker->numberBetween(0, 50),
            'language' => 'it',
            'is_featured' => $this->faker->boolean(20),
            'published_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'is_draft' => false,
            'word_count' => $this->faker->numberBetween(20, 150),
        ];
    }
}

