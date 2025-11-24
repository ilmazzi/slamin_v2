<?php

return [
    // General
    'groups' => 'Gruppi',
    'group' => 'Gruppo',
    'create_group' => 'Crea Gruppo',
    'edit_group' => 'Modifica Gruppo',
    'delete_group' => 'Elimina Gruppo',
    'my_groups' => 'I Miei Gruppi',
    'all_groups' => 'Tutti i Gruppi',
    'public_groups' => 'Gruppi Pubblici',
    'private_groups' => 'Gruppi Privati',
    
    // Group Info
    'name' => 'Nome',
    'description' => 'Descrizione',
    'image' => 'Immagine',
    'visibility' => 'Visibilità',
    'public' => 'Pubblico',
    'private' => 'Privato',
    'created_by' => 'Creato da',
    'created_at' => 'Creato il',
    
    // Members
    'members' => 'Membri',
    'member' => 'Membro',
    'admin' => 'Admin',
    'moderator' => 'Moderatore',
    'member_count' => '{0} Nessun membro|{1} 1 membro|[2,*] :count membri',
    
    // Actions
    'join' => 'Unisciti',
    'leave' => 'Lascia',
    'request_access' => 'Richiedi Accesso',
    'invite_members' => 'Invita Membri',
    'manage_members' => 'Gestisci Membri',
    
    // Messages
    'group_created' => 'Gruppo creato con successo',
    'group_updated' => 'Gruppo aggiornato con successo',
    'group_deleted' => 'Gruppo eliminato con successo',
    'joined_successfully' => 'Ti sei unito al gruppo con successo',
    'left_successfully' => 'Hai lasciato il gruppo',
    'request_sent' => 'Richiesta di accesso inviata',
    'already_member' => 'Sei già membro di questo gruppo',
    'request_already_sent' => 'Hai già inviato una richiesta di accesso',
    'cannot_leave_as_last_admin' => 'Non puoi lasciare il gruppo essendo l\'unico admin',
    
    // Sections
    'about' => 'Informazioni',
    'announcements' => 'Annunci',
    'events' => 'Eventi',
    'photos' => 'Foto',
    
    // Social
    'website' => 'Sito Web',
    'social_links' => 'Link Social',
    
    // Empty States
    'no_groups' => 'Nessun gruppo trovato',
    'no_members' => 'Nessun membro',
    'no_announcements' => 'Nessun annuncio',
    'no_events' => 'Nessun evento',
    
    // Member Management
    'member_promoted' => 'Membro promosso a moderatore',
    'member_demoted' => 'Moderatore retrocesso a membro',
    'member_removed' => 'Membro rimosso dal gruppo',
    'cannot_remove_admin' => 'Non puoi rimuovere un admin',
    'user_already_member' => 'L\'utente è già membro del gruppo',
    
    // Invitations
    'invitation_sent' => 'Invito inviato con successo',
    'invitation_accepted' => 'Invito accettato',
    'invitation_declined' => 'Invito rifiutato',
    'invitation_already_sent' => 'Invito già inviato a questo utente',
    'invitation_not_valid' => 'Invito non valido',
    'invitation_expired' => 'Invito scaduto',
    
    // Join Requests
    'request_approved' => 'Richiesta approvata',
    'request_declined' => 'Richiesta rifiutata',
    'request_not_valid' => 'Richiesta non valida',
    
    // Announcements
    'announcement_created' => 'Annuncio creato con successo',
    'announcement_updated' => 'Annuncio aggiornato con successo',
    'announcement_deleted' => 'Annuncio eliminato con successo',
    'no_permission_view_announcements' => 'Non hai i permessi per visualizzare gli annunci',
    'no_permission_view_announcement' => 'Non hai i permessi per visualizzare questo annuncio',
    'no_permission_create_announcement' => 'Non hai i permessi per creare annunci',
    'no_permission_edit_announcement' => 'Non hai i permessi per modificare questo annuncio',
    'no_permission_delete_announcement' => 'Non hai i permessi per eliminare questo annuncio',
    
    // Permissions
    'no_permission_view_members' => 'Non hai i permessi per visualizzare i membri',
    'no_permission_invite' => 'Non hai i permessi per invitare utenti',
    'no_permission_view_invitations' => 'Non hai i permessi per visualizzare gli inviti',
    'no_permission_view_invitation' => 'Non hai i permessi per visualizzare questo invito',
    'no_permission_view_requests' => 'Non hai i permessi per visualizzare le richieste',
    'no_permission_view_request' => 'Non hai i permessi per visualizzare questa richiesta',
    'no_permission_accept_requests' => 'Non hai i permessi per accettare richieste',
    'no_permission_decline_requests' => 'Non hai i permessi per rifiutare richieste',
    'no_permission_view_stats' => 'Non hai i permessi per visualizzare le statistiche',
    
    // Additional Messages
    'already_admin' => 'L\'utente è già admin',
    'not_admin' => 'L\'utente non è admin',
    'cannot_demote_last_admin' => 'Non puoi retrocedere l\'ultimo admin',
    'already_moderator' => 'L\'utente è già moderatore',
    'not_moderator' => 'L\'utente non è moderatore',
    'promoted_to_moderator' => 'Utente promosso a moderatore',
    'demoted_to_member' => 'Utente retrocesso a membro',
    'cannot_remove_yourself' => 'Non puoi rimuovere te stesso',
    'cannot_remove_last_admin' => 'Non puoi rimuovere l\'ultimo admin',
    'user_has_pending_request' => 'L\'utente ha già una richiesta pendente',
    'cannot_accept_others_invitation' => 'Non puoi accettare inviti di altri',
    'cannot_decline_others_invitation' => 'Non puoi rifiutare inviti di altri',
    'cannot_cancel_others_invitation' => 'Non puoi cancellare inviti di altri',
    'cannot_resend_others_invitation' => 'Non puoi rinviare inviti di altri',
    'invitation_not_expired' => 'Questo invito non è scaduto',
    'invitation_resent' => 'Invito rinviato con successo',
    'invitation_cancelled' => 'Invito cancellato',
    'cannot_cancel_others_request' => 'Non puoi cancellare richieste di altri',
    'request_cancelled' => 'Richiesta cancellata',
    
    // Notifications
    'notification' => [
        'invitation_received' => 'Nuovo invito al gruppo',
        'invitation_message' => ':inviter ti ha invitato a unirti al gruppo :group',
        'invitation_response' => 'Risposta all\'invito',
        'invitation_accepted_message' => ':user ha accettato il tuo invito a :group',
        'invitation_declined_message' => ':user ha rifiutato il tuo invito a :group',
        'join_request_received' => 'Nuova richiesta di partecipazione',
        'join_request_message' => ':user vuole unirsi al gruppo :group',
        'request_response' => 'Risposta alla richiesta',
        'request_accepted_message' => 'La tua richiesta di unirsi a :group è stata accettata',
        'request_declined_message' => 'La tua richiesta di unirsi a :group è stata rifiutata',
        'new_announcement' => 'Nuovo annuncio',
        'announcement_message' => 'Nuovo annuncio in :group: :title',
    ],
];

