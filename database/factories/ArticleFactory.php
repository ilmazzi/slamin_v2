<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $titles = [
            'La Poesia nell\'Era Digitale',
            'Come Scrivere Versi che Emozionano',
            'I Grandi Poeti Italiani del Novecento',
            'Haiku: L\'Arte della Brevità',
            'Metafore e Similitudini nella Poesia Moderna',
            'La Musica dei Versi',
            'Quando la Poesia Incontra la Fotografia',
            'Il Ritmo nelle Parole',
        ];

        $title = $this->faker->randomElement($titles) . ' ' . Str::random(4);
        $slug = Str::slug($title) . '-' . $this->faker->unique()->numberBetween(10000, 99999);

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $title,
            'content' => $this->faker->paragraphs(5, true),
            'excerpt' => $this->faker->sentence(20),
            'featured_image' => 'https://images.unsplash.com/photo-' . $this->faker->randomElement([
                '1516589178581-6cd7833ae3b2',
                '1506157786151-b8491531f063',
                '1455390582262-044cdead277a',
                '1519681393784-d120267933ba',
            ]) . '?w=1200&auto=format&fit=crop',
            'status' => 'published',
            'moderation_status' => 'approved',
            'is_public' => true,
            'featured' => $this->faker->boolean(30),
            'view_count' => $this->faker->numberBetween(100, 5000),
            'like_count' => $this->faker->numberBetween(20, 500),
            'comment_count' => $this->faker->numberBetween(5, 100),
            'slug' => $slug,
            'published_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'language' => 'it',
        ];
    }
}

