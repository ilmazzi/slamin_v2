<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\OnlineStatusService;
use Illuminate\Support\Facades\Auth;

class UpdateOnlineStatus
{
    protected $onlineStatusService;

    public function __construct(OnlineStatusService $onlineStatusService)
    {
        $this->onlineStatusService = $onlineStatusService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Aggiorna lo stato online dell'utente (rinnova il TTL)
            $this->onlineStatusService->setOnline(Auth::id());
            
            // Aggiorna anche last_seen_at (con throttling)
            $this->onlineStatusService->touchLastSeen(Auth::user());
            
            // Pulisci le voci scadute ogni 100 richieste (per non sovraccaricare)
            if (rand(1, 100) === 1) {
                $this->onlineStatusService->cleanupExpired();
            }
        }

        return $next($request);
    }
}
