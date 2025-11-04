<?php

namespace Database\Factories;

use App\Models\Video;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array
    {
        $titles = [
            'Recita di "Infinito" di Leopardi',
            'La Mia Poesia Preferita',
            'Versi al Tramonto',
            'Performance Poetica Live',
            'Slam Poetry - Milano 2024',
            'Lettura Emotiva',
        ];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => fake()->randomElement($titles),
            'description' => fake()->sentence(15),
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Placeholder
            'thumbnail' => 'https://images.unsplash.com/photo-' . fake()->randomElement([
                '1507003211169-0a1dd7228f2d',
                '1494790108377-be9c29b29330',
                '1506794778202-cad84cf45f1d',
            ]) . '?w=800&auto=format&fit=crop',
            'duration' => fake()->numberBetween(60, 600), // seconds
            'view_count' => fake()->numberBetween(100, 5000),
            'like_count' => fake()->numberBetween(20, 500),
            'comment_count' => fake()->numberBetween(0, 100),
            'is_public' => true,
            'status' => 'published',
            'moderation_status' => 'approved',
        ];
    }
}

