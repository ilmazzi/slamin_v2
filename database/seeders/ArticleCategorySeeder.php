<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ArticleCategory;
use Illuminate\Support\Str;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => json_encode([
                    'it' => 'Tecniche di Scrittura',
                    'en' => 'Writing Techniques',
                    'fr' => 'Techniques d\'Écriture',
                    'de' => 'Schreibtechniken',
                    'es' => 'Técnicas de Escritura',
                    'pt' => 'Técnicas de Escrita'
                ]),
                'slug' => 'writing-techniques',
                'description' => json_encode([
                    'it' => 'Consigli e tecniche per migliorare la tua scrittura poetica e letteraria',
                    'en' => 'Tips and techniques to improve your poetic and literary writing',
                    'fr' => 'Conseils et techniques pour améliorer votre écriture poétique et littéraire',
                ]),
                'icon' => '✍️',
                'color' => '#3b82f6',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => json_encode([
                    'it' => 'Interviste',
                    'en' => 'Interviews',
                    'fr' => 'Interviews',
                    'de' => 'Interviews',
                    'es' => 'Entrevistas',
                    'pt' => 'Entrevistas'
                ]),
                'slug' => 'interviews',
                'description' => json_encode([
                    'it' => 'Conversazioni con poeti, scrittori e artisti',
                    'en' => 'Conversations with poets, writers and artists',
                    'fr' => 'Conversations avec des poètes, écrivains et artistes',
                ]),
                'icon' => '🎤',
                'color' => '#10b981',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => json_encode([
                    'it' => 'Recensioni',
                    'en' => 'Reviews',
                    'fr' => 'Critiques',
                    'de' => 'Rezensionen',
                    'es' => 'Reseñas',
                    'pt' => 'Resenhas'
                ]),
                'slug' => 'reviews',
                'description' => json_encode([
                    'it' => 'Recensioni di libri, raccolte poetiche e opere letterarie',
                    'en' => 'Reviews of books, poetry collections and literary works',
                    'fr' => 'Critiques de livres, recueils de poésie et œuvres littéraires',
                ]),
                'icon' => '📚',
                'color' => '#f59e0b',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => json_encode([
                    'it' => 'Poetry Slam',
                    'en' => 'Poetry Slam',
                    'fr' => 'Poetry Slam',
                    'de' => 'Poetry Slam',
                    'es' => 'Poetry Slam',
                    'pt' => 'Poetry Slam'
                ]),
                'slug' => 'poetry-slam',
                'description' => json_encode([
                    'it' => 'Tutto sul mondo del Poetry Slam: eventi, competizioni e performance',
                    'en' => 'Everything about the Poetry Slam world: events, competitions and performances',
                    'fr' => 'Tout sur le monde du Poetry Slam : événements, compétitions et performances',
                ]),
                'icon' => '🎭',
                'color' => '#ef4444',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => json_encode([
                    'it' => 'Eventi e Festival',
                    'en' => 'Events and Festivals',
                    'fr' => 'Événements et Festivals',
                    'de' => 'Events und Festivals',
                    'es' => 'Eventos y Festivales',
                    'pt' => 'Eventos e Festivais'
                ]),
                'slug' => 'events-festivals',
                'description' => json_encode([
                    'it' => 'Notizie su eventi letterari, festival di poesia e manifestazioni culturali',
                    'en' => 'News about literary events, poetry festivals and cultural events',
                    'fr' => 'Actualités sur les événements littéraires, festivals de poésie et manifestations culturelles',
                ]),
                'icon' => '🎪',
                'color' => '#8b5cf6',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => json_encode([
                    'it' => 'Comunità',
                    'en' => 'Community',
                    'fr' => 'Communauté',
                    'de' => 'Gemeinschaft',
                    'es' => 'Comunidad',
                    'pt' => 'Comunidade'
                ]),
                'slug' => 'community',
                'description' => json_encode([
                    'it' => 'Storie, esperienze e riflessioni dalla nostra comunità di poeti',
                    'en' => 'Stories, experiences and reflections from our poets community',
                    'fr' => 'Histoires, expériences et réflexions de notre communauté de poètes',
                ]),
                'icon' => '👥',
                'color' => '#06b6d4',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => json_encode([
                    'it' => 'Storia e Teoria',
                    'en' => 'History and Theory',
                    'fr' => 'Histoire et Théorie',
                    'de' => 'Geschichte und Theorie',
                    'es' => 'Historia y Teoría',
                    'pt' => 'História e Teoria'
                ]),
                'slug' => 'history-theory',
                'description' => json_encode([
                    'it' => 'Approfondimenti sulla storia della poesia e teorie letterarie',
                    'en' => 'Insights into the history of poetry and literary theories',
                    'fr' => 'Aperçus de l\'histoire de la poésie et des théories littéraires',
                ]),
                'icon' => '📖',
                'color' => '#64748b',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => json_encode([
                    'it' => 'Ispirazione',
                    'en' => 'Inspiration',
                    'fr' => 'Inspiration',
                    'de' => 'Inspiration',
                    'es' => 'Inspiración',
                    'pt' => 'Inspiração'
                ]),
                'slug' => 'inspiration',
                'description' => json_encode([
                    'it' => 'Prompts creativi, esercizi e spunti per ispirare la tua scrittura',
                    'en' => 'Creative prompts, exercises and ideas to inspire your writing',
                    'fr' => 'Prompts créatifs, exercices et idées pour inspirer votre écriture',
                ]),
                'icon' => '💡',
                'color' => '#eab308',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ArticleCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('✅ Article categories seeded successfully!');
    }
}
