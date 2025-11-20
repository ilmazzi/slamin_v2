<?php

return [
    'title' => 'Impostazioni Admin',
    'description' => 'Gestisci tutte le impostazioni e funzionalità del sistema da questa pagina centrale.',
    'sidebar' => 'Admin Settings',
    'menu' => 'Admin Settings',
    
    'sections' => [
        'dashboard' => [
            'title' => 'Dashboard',
            'description' => 'Panoramica generale e statistiche',
        ],
        'users' => [
            'title' => 'Gestione Utenti',
            'description' => 'Gestisci utenti, ruoli e permessi',
        ],
        'moderation' => [
            'title' => 'Moderazione',
            'description' => 'Approvazione e gestione contenuti',
        ],
        'articles' => [
            'title' => 'Gestione Articoli',
            'description' => 'Crea e gestisci articoli',
        ],
        'carousels' => [
            'title' => 'Gestione Carousel',
            'description' => 'Gestisci il carousel della homepage',
        ],
        'settings' => [
            'title' => 'Impostazioni Sistema',
            'description' => 'Configurazione generale del sistema',
        ],
        'payment_settings' => [
            'title' => 'Impostazioni Pagamenti',
            'description' => 'Configurazione pagamenti e commissioni',
        ],
        'upload_settings' => [
            'title' => 'Impostazioni Upload',
            'description' => 'Limiti e configurazione upload',
        ],
        'logs' => [
            'title' => 'Log Sistema',
            'description' => 'Visualizza log attività ed errori',
        ],
        'gamification' => [
            'title' => 'Gamificazione',
            'description' => 'Gestisci badge e punti utente',
        ],
        'social_settings' => [
            'title' => 'Impostazioni Social',
            'description' => 'Configura like, commenti e notifiche',
        ],
        'article_layout' => [
            'title' => 'Layout Articoli',
            'description' => 'Gestisci il layout degli articoli nella homepage',
        ],
        'placeholder_settings' => [
            'title' => 'Impostazioni Placeholder',
            'description' => 'Configura i colori dei placeholder',
        ],
        'payment_accounts' => [
            'title' => 'Conti Pagamento',
            'description' => 'Gestisci conti Stripe e PayPal utenti',
        ],
        'payouts' => [
            'title' => 'Payout',
            'description' => 'Gestisci i pagamenti ai traduttori',
        ],
        'gig_positions' => [
            'title' => 'Posizioni Gig',
            'description' => 'Gestisci le posizioni disponibili per i gig',
        ],
        'peertube' => [
            'title' => 'Impostazioni PeerTube',
            'description' => 'Configurazione PeerTube per video utenti',
        ],
    ],
    
    'social_settings' => [
        'title' => 'Impostazioni Social',
        'description' => 'Gestisci le funzionalità social della piattaforma',
        'updated_success' => 'Impostazioni social aggiornate con successo',
        'update_error' => 'Errore durante l\'aggiornamento delle impostazioni social',
        'reset' => 'Ripristina Default',
        'reset_success' => 'Impostazioni social ripristinate ai valori di default',
    ],
    'placeholder_settings' => [
        'title' => 'Impostazioni Placeholder',
        'description' => 'Gestisci i colori dei placeholder per poesie, articoli ed eventi',
        'poem_color' => 'Colore Placeholder Poesie',
        'article_color' => 'Colore Placeholder Articoli',
        'event_color' => 'Colore Placeholder Eventi',
        'poem_color_required' => 'Il colore per le poesie è obbligatorio',
        'article_color_required' => 'Il colore per gli articoli è obbligatorio',
        'color_regex' => 'Il colore deve essere un codice esadecimale valido (es. #ff0000)',
        'updated_success' => 'Impostazioni placeholder aggiornate con successo',
        'update_error' => 'Errore durante l\'aggiornamento delle impostazioni placeholder',
    ],
    'payment_accounts' => [
        'title' => 'Gestione Conti Pagamento',
        'description' => 'Gestisci conti Stripe e PayPal degli utenti',
        'total_users' => 'Totale Utenti',
        'stripe_connected' => 'Stripe Connessi',
        'paypal_connected' => 'PayPal Connessi',
        'pending_verification' => 'In Attesa Verifica',
        'no_paypal_email' => 'Utente senza email PayPal',
        'paypal_verified' => 'Account PayPal verificato per :name',
        'paypal_unverified' => 'Verifica PayPal revocata per :name',
        'account_disconnected' => 'Account :type disconnesso per :name',
        'placeholder' => 'Lista utenti con conti Stripe e PayPal',
    ],
    'payouts' => [
        'title' => 'Gestione Payout',
        'description' => 'Gestisci i pagamenti ai traduttori',
        'total_payments' => 'Totale Pagamenti',
        'pending_payouts' => 'Payout In Attesa',
        'total_amount' => 'Importo Totale',
        'processed_success' => 'Payout processato con successo',
        'process_error' => 'Errore durante il processamento del payout',
        'processed_all' => 'Processati :success payout con successo, :failed falliti',
        'process_all_error' => 'Errore durante il processamento di tutti i payout',
        'skipped_by_admin' => 'Payout saltato dall\'admin',
        'skipped_success' => 'Payout saltato',
        'invalid_action' => 'Azione non valida',
        'placeholder' => 'Lista payout e pagamenti',
    ],
    'gig_positions' => [
        'title' => 'Gestione Posizioni Gig',
        'description' => 'Gestisci le posizioni disponibili per i gig',
        'create' => 'Crea Nuova Posizione',
        'updated_success' => 'Posizione aggiornata con successo',
        'created_success' => 'Posizione creata con successo',
        'save_error' => 'Errore durante il salvataggio della posizione',
        'cannot_delete_in_use' => 'Impossibile eliminare: la posizione è in uso',
        'deleted_success' => 'Posizione eliminata con successo',
        'delete_error' => 'Errore durante l\'eliminazione della posizione',
        'status_updated' => 'Stato posizione aggiornato',
        'placeholder' => 'Lista posizioni gig',
    ],
    'peertube' => [
        'title' => 'Impostazioni PeerTube',
        'description' => 'Gestisci la configurazione PeerTube per i video degli utenti',
        'url' => 'URL PeerTube',
        'admin_username' => 'Username Admin',
        'admin_password' => 'Password Admin',
        'test_connection' => 'Testa Connessione',
        'updated_success' => 'Impostazioni PeerTube aggiornate con successo',
        'update_error' => 'Errore durante l\'aggiornamento delle impostazioni PeerTube',
        'connection_success' => 'Connessione riuscita',
        'connection_failed' => 'Connessione fallita',
        'connection_error' => 'Errore durante il test di connessione',
    ],
];