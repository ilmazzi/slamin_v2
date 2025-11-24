<?php

namespace App\Listeners;

use App\Events\SocialInteractionReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SocialInteractionNotification;
use Illuminate\Support\Facades\Log;

class SendSocialInteractionNotification // implements ShouldQueue
{
    /**
     * Array to track processed interactions in this request
     */
    private static $processedInteractions = [];

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SocialInteractionReceived $event): void
    {
        // Crea un hash unico per questa interazione
        $interactionHash = md5(
            $event->interactor->id . 
            $event->contentOwner->id . 
            $event->type . 
            get_class($event->content) . 
            $event->content->id
        );

        \Log::info('SendSocialInteractionNotification listener triggered', [
            'interactor_id' => $event->interactor->id,
            'owner_id' => $event->contentOwner->id,
            'type' => $event->type,
            'interaction_id' => $event->interaction->id ?? 'N/A',
            'hash' => $interactionHash,
            'already_processed' => in_array($interactionHash, self::$processedInteractions),
        ]);

        // Controlla se abbiamo già processato questa interazione in questa richiesta
        if (in_array($interactionHash, self::$processedInteractions)) {
            \Log::info('Skipping notification: already processed in this request');
            return;
        }

        // Aggiungi alla lista delle interazioni processate
        self::$processedInteractions[] = $interactionHash;
        
        // Non mandare notifica se l'utente interagisce con il proprio contenuto
        if ($event->interactor->id === $event->contentOwner->id) {
            \Log::info('Skipping notification: user interacted with own content');
            return;
        }

        // Invia la notifica
        \Log::info('Sending notification to user', ['user_id' => $event->contentOwner->id]);
        $event->contentOwner->notify(new SocialInteractionNotification(
            $event->interaction,
            $event->interactor,
            $event->content,
            $event->type
        ));
        \Log::info('Notification sent successfully');
    }
}