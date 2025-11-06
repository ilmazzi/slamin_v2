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

        $peertubeUuid = $this->faker->uuid();
        
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->randomElement($titles),
            'description' => $this->faker->sentence(15),
            'video_url' => 'https://video.slamin.it/videos/watch/' . $peertubeUuid,
            'peertube_uuid' => $peertubeUuid,
            'peertube_video_id' => $this->faker->numberBetween(1, 1000),
            'peertube_direct_url' => 'https://download.blender.org/demo/movies/BBB/bbb_sunflower_1080p_30fps_normal.mp4', // URL MP4 di esempio funzionante
            'thumbnail_path' => 'https://images.unsplash.com/photo-' . $this->faker->randomElement([
                '1507003211169-0a1dd7228f2d',
                '1494790108377-be9c29b29330',
                '1506794778202-cad84cf45f1d',
            ]) . '?w=800&auto=format&fit=crop',
            'duration' => $this->faker->numberBetween(60, 600), // seconds
            'view_count' => $this->faker->numberBetween(100, 5000),
            'like_count' => $this->faker->numberBetween(20, 500),
            'comment_count' => $this->faker->numberBetween(0, 100),
            'is_public' => true,
            'status' => 'published',
            'moderation_status' => 'approved',
            'peertube_status' => 'ready',
        ];
    }
}

