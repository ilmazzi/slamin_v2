<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lingue disponibili
        $availableLocales = ['it', 'en', 'fr', 'es', 'de', 'pt', 'pt-br', 'nl', 'pl', 'ru', 'ja', 'zh', 'ar', 'hi', 'ko'];
        
        // 1. Controlla se c'è un parametro 'lang' nella query string
        if ($request->has('lang')) {
            $locale = $request->query('lang');
            
            // Valida che la lingua sia supportata
            if (in_array($locale, $availableLocales)) {
                // Salva nella sessione
                $request->session()->put('locale', $locale);
                // Imposta la locale dell'applicazione
                App::setLocale($locale);
            }
        } 
        // 2. Se non c'è parametro ma c'è una sessione salvata, usa quella
        elseif ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
            if (in_array($locale, $availableLocales)) {
                App::setLocale($locale);
            }
        }
        // 3. Altrimenti usa la locale di default da config
        // (già impostata automaticamente da Laravel)
        
        return $next($request);
    }
}
