<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe($token)
    {
        $subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->first();

        if (!$subscriber) {
            return redirect()->route('home')
                ->with('error', 'Token di disiscrizione non valido.');
        }

        if ($subscriber->status === 'unsubscribed') {
            return redirect()->route('home')
                ->with('info', 'Sei già disiscritto dalla newsletter.');
        }

        $subscriber->unsubscribe();

        return redirect()->route('home')
            ->with('success', 'Disiscrizione completata con successo.');
    }
}
