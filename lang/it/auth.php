<?php

return [
    // Password Reset
    'forgot_password' => 'Password Dimenticata',
    'forgot_password_description' => 'Inserisci la tua email e ti invieremo un link per reimpostare la password',
    'reset_password' => 'Reimposta Password',
    'reset_password_description' => 'Inserisci la tua email e la nuova password',
    'send_reset_link' => 'Invia Link di Reset',
    'reset_link_sent' => 'Link di reset inviato!',
    'reset_link_sent_description' => 'Ti abbiamo inviato un link di reset all\'indirizzo :email. Controlla la tua casella di posta e segui le istruzioni.',
    'password_reset_failed' => 'Impossibile inviare il link di reset. Verifica l\'email inserita.',
    'password_reset_success' => 'Password reimpostata con successo! Ora puoi accedere con la nuova password.',
    'password_reset_help_title' => 'Hai dimenticato la password?',
    'password_reset_help_description' => 'Non preoccuparti! Inserisci la tua email e ti invieremo un link sicuro per reimpostare la tua password.',
    'secure_password_title' => 'Scegli una password sicura',
    'secure_password_description' => 'Assicurati di utilizzare una password forte con almeno 8 caratteri, contenente lettere maiuscole, minuscole e numeri.',
    'reset_password_button' => 'Reimposta Password',
    
    // Form Fields
    'email' => 'Email',
    'email_placeholder' => 'Inserisci la tua email',
    'password' => 'Password',
    'password_placeholder' => 'Inserisci la tua password',
    'new_password' => 'Nuova Password',
    'new_password_placeholder' => 'Inserisci la nuova password',
    'confirm_password' => 'Conferma Password',
    'confirm_password_placeholder' => 'Conferma la password',
    'password_requirements' => 'Minimo 8 caratteri, una lettera maiuscola e un numero',
    
    // Actions
    'back_to_login' => 'Torna al Login',
    
    // Validation Messages (from controller)
    'name_required' => 'Il nome è obbligatorio',
    'nickname_unique' => 'Questo nickname è già in uso',
    'email_required' => 'L\'email è obbligatoria',
    'email_valid' => 'Inserisci un\'email valida',
    'email_unique' => 'Questa email è già registrata',
    'password_required' => 'La password è obbligatoria',
    'password_min' => 'La password deve essere di almeno 8 caratteri',
    'password_confirmed' => 'Le password non coincidono',
    'credentials_invalid' => 'Credenziali non valide',
    'logout_success' => 'Logout effettuato con successo',
    
    // Email Verification
    'email_verification_required' => 'Verifica Email Richiesta',
    'email_verification_description' => 'Prima di continuare, verifica il tuo indirizzo email cliccando sul link che ti abbiamo inviato.',
    'email_not_received' => 'Se non hai ricevuto l\'email',
    'resend_verification' => 'Invia di nuovo l\'email di verifica',
    'verification_link_sent' => 'Un nuovo link di verifica è stato inviato al tuo indirizzo email',
    
    // User Roles (used in auth context)
    'role_admin' => 'Amministratore',
    'role_moderator' => 'Moderatore',
    'role_poet' => 'Poeta',
    'role_organizer' => 'Organizzatore',
    'role_judge' => 'Giudice',
    'role_venue_owner' => 'Proprietario Locale',
    'role_technician' => 'Tecnico',
    'role_audience' => 'Spettatore',
    
    // Welcome Messages
    'welcome_back' => 'Ti diamo il bentornato, :name!',
    'welcome_back_remember' => 'Ti diamo il bentornato, :name! Ti ricorderemo per i prossimi accessi.',
    
    // Email Verification
    'verify_email_subject' => 'Verifica il tuo indirizzo email',
    'verify_email_line1' => 'Clicca sul pulsante sottostante per verificare il tuo indirizzo email.',
    'verify_email_action' => 'Verifica Indirizzo Email',
    'verify_email_line2' => 'Se non hai creato un account, non è necessaria alcuna azione.',
    'verify_email_line3' => 'Questo link di verifica scadrà tra 60 minuti.',
    'email_verified_success' => 'Email verificata con successo! Ora puoi accedere a tutte le funzionalità.',
    
    // Reset Password Email
    'reset_password_notification' => 'Reimposta la tua Password',
    'reset_password_reason' => 'Hai ricevuto questa email perché abbiamo ricevuto una richiesta di reset password per il tuo account.',
    'reset_password_action' => 'Reimposta Password',
    'reset_password_expire' => 'Questo link di reset password scadrà tra :count minuti.',
    'reset_password_no_action' => 'Se non hai richiesto il reset della password, non è necessaria alcuna azione.',
];

