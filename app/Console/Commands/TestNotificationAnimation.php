<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Poem;
use App\Events\SocialInteractionReceived;
use App\Models\UnifiedLike;

class TestNotificationAnimation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notification {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test notification animation for a specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found!");
            return 1;
        }

        $this->info("Testing notification for user: {$user->name} (ID: {$user->id})");

        // Trova un contenuto dell'utente (o creane uno fittizio)
        $poem = Poem::where('user_id', $user->id)->first();
        
        if (!$poem) {
            $this->error("No content found for this user. Creating a test poem...");
            $poem = Poem::create([
                'user_id' => $user->id,
                'title' => 'Test Poem for Notification',
                'content' => 'This is a test poem',
                'status' => 'published',
                'slug' => 'test-poem-' . time(),
            ]);
        }

        // Trova un altro utente per simulare il like
        $otherUser = User::where('id', '!=', $user->id)->first();
        
        if (!$otherUser) {
            $this->error("No other user found to simulate the like!");
            return 1;
        }

        $this->info("Simulating like from user: {$otherUser->name} (ID: {$otherUser->id})");

        // Crea un like fittizio
        $like = new UnifiedLike([
            'user_id' => $otherUser->id,
            'likeable_type' => Poem::class,
            'likeable_id' => $poem->id,
        ]);

        // Dispatcha l'evento
        $this->info("Dispatching SocialInteractionReceived event...");
        event(new SocialInteractionReceived($like, $otherUser, $user, $poem, 'like'));

        $this->info("Event dispatched! Check if the notification appears in the browser.");
        $this->info("Also check the notifications table:");
        $this->call('db:table', ['table' => 'notifications', '--limit' => 5]);

        return 0;
    }
}
