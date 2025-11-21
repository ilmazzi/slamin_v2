<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Log;
use App\Services\PeerTubeService;

class CreatePeerTubeAccount
{

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
    public function handle(Verified $event): void
    {
        $user = $event->user;

        try {
            Log::info('Evento EmailVerified ricevuto - Inizio creazione account PeerTube', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            // Se l'utente ha già un account PeerTube, non fare nulla
            if ($user->peertube_user_id) {
                Log::info('Utente ha già un account PeerTube - Skip', [
                    'user_id' => $user->id,
                    'peertube_user_id' => $user->peertube_user_id
                ]);
                return;
            }

            // Recupera i ruoli salvati durante la registrazione
            $roles = json_decode($user->peertube_roles ?? '[]', true);
            
            // Se non ci sono ruoli salvati, usa 'audience' come default
            if (empty($roles)) {
                $roles = ['audience'];
            }

            Log::info('Ruoli PeerTube recuperati', [
                'user_id' => $user->id,
                'roles' => $roles
            ]);

            // Genera una password temporanea per PeerTube
            $peerTubePassword = \Illuminate\Support\Str::random(16);

            // Crea l'account PeerTube
            $peerTubeService = new PeerTubeService();
            $success = $peerTubeService->createPeerTubeUser($user, $peerTubePassword);

            if ($success) {
                Log::info('Account PeerTube creato con successo', [
                    'user_id' => $user->id,
                    'peertube_user_id' => $user->peertube_user_id
                ]);

                // Pulisci i ruoli salvati temporaneamente
                $user->update([
                    'peertube_roles' => null
                ]);
            } else {
                Log::error('Errore creazione account PeerTube', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Eccezione durante creazione account PeerTube', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
