<?php

return [
    // General
    'groups' => 'Groupes',
    'group' => 'Groupe',
    'create_group' => 'Créer un Groupe',
    'edit_group' => 'Modifier le Groupe',
    'delete_group' => 'Supprimer le Groupe',
    'my_groups' => 'Mes Groupes',
    'all_groups' => 'Tous les Groupes',
    'public_groups' => 'Groupes Publics',
    'private_groups' => 'Groupes Privés',
    
    // Group Info
    'name' => 'Nom',
    'description' => 'Description',
    'image' => 'Image',
    'visibility' => 'Visibilité',
    'public' => 'Public',
    'private' => 'Privé',
    'created_by' => 'Créé par',
    'created_at' => 'Créé le',
    
    // Members
    'members' => 'Membres',
    'member' => 'Membre',
    'admin' => 'Admin',
    'moderator' => 'Modérateur',
    'member_count' => '{0} Aucun membre|{1} 1 membre|[2,*] :count membres',
    
    // Actions
    'join' => 'Rejoindre',
    'leave' => 'Quitter',
    'request_access' => 'Demander l\'accès',
    'invite_members' => 'Inviter des Membres',
    'manage_members' => 'Gérer les Membres',
    
    // Messages
    'group_created' => 'Groupe créé avec succès',
    'group_updated' => 'Groupe mis à jour avec succès',
    'group_deleted' => 'Groupe supprimé avec succès',
    'joined_successfully' => 'Vous avez rejoint le groupe avec succès',
    'left_successfully' => 'Vous avez quitté le groupe',
    'request_sent' => 'Demande d\'accès envoyée',
    'already_member' => 'Vous êtes déjà membre de ce groupe',
    'request_already_sent' => 'Vous avez déjà envoyé une demande d\'accès',
    'cannot_leave_as_last_admin' => 'Vous ne pouvez pas quitter le groupe en tant que seul admin',
    
    // Sections
    'about' => 'À propos',
    'announcements' => 'Annonces',
    'events' => 'Événements',
    'photos' => 'Photos',
    
    // Social
    'website' => 'Site Web',
    'social_links' => 'Liens Sociaux',
    
    // Empty States
    'no_groups' => 'Aucun groupe trouvé',
    'no_members' => 'Aucun membre',
    'no_announcements' => 'Aucune annonce',
    'no_events' => 'Aucun événement',
    
    // Member Management
    'member_promoted' => 'Membre promu modérateur',
    'member_demoted' => 'Modérateur rétrogradé en membre',
    'member_removed' => 'Membre retiré du groupe',
    'cannot_remove_admin' => 'Impossible de retirer un admin',
    'user_already_member' => 'L\'utilisateur est déjà membre',
    
    // Invitations
    'invitation_sent' => 'Invitation envoyée avec succès',
    'invitation_accepted' => 'Invitation acceptée',
    'invitation_declined' => 'Invitation refusée',
    'invitation_already_sent' => 'Invitation déjà envoyée à cet utilisateur',
    'invitation_not_valid' => 'Invitation non valide',
    'invitation_expired' => 'Invitation expirée',
    
    // Join Requests
    'request_approved' => 'Demande approuvée',
    'request_declined' => 'Demande refusée',
    'request_not_valid' => 'Demande non valide',
    
    // Announcements
    'announcement_created' => 'Annonce créée avec succès',
    'announcement_updated' => 'Annonce mise à jour avec succès',
    'announcement_deleted' => 'Annonce supprimée avec succès',
    'no_permission_view_announcements' => 'Vous n\'avez pas la permission de voir les annonces',
    'no_permission_view_announcement' => 'Vous n\'avez pas la permission de voir cette annonce',
    'no_permission_create_announcement' => 'Vous n\'avez pas la permission de créer des annonces',
    'no_permission_edit_announcement' => 'Vous n\'avez pas la permission de modifier cette annonce',
    'no_permission_delete_announcement' => 'Vous n\'avez pas la permission de supprimer cette annonce',
    
    // Permissions
    'no_permission_view_members' => 'Vous n\'avez pas la permission de voir les membres',
    'no_permission_invite' => 'Vous n\'avez pas la permission d\'inviter des utilisateurs',
    'no_permission_view_invitations' => 'Vous n\'avez pas la permission de voir les invitations',
    'no_permission_view_invitation' => 'Vous n\'avez pas la permission de voir cette invitation',
    'no_permission_view_requests' => 'Vous n\'avez pas la permission de voir les demandes',
    'no_permission_view_request' => 'Vous n\'avez pas la permission de voir cette demande',
    'no_permission_accept_requests' => 'Vous n\'avez pas la permission d\'accepter les demandes',
    'no_permission_decline_requests' => 'Vous n\'avez pas la permission de refuser les demandes',
    'no_permission_view_stats' => 'Vous n\'avez pas la permission de voir les statistiques',
    
    // Additional Messages
    'already_admin' => 'L\'utilisateur est déjà admin',
    'not_admin' => 'L\'utilisateur n\'est pas admin',
    'cannot_demote_last_admin' => 'Impossible de rétrograder le dernier admin',
    'already_moderator' => 'L\'utilisateur est déjà modérateur',
    'not_moderator' => 'L\'utilisateur n\'est pas modérateur',
    'promoted_to_moderator' => 'Utilisateur promu modérateur',
    'demoted_to_member' => 'Utilisateur rétrogradé en membre',
    'cannot_remove_yourself' => 'Vous ne pouvez pas vous retirer vous-même',
    'cannot_remove_last_admin' => 'Impossible de retirer le dernier admin',
    'user_has_pending_request' => 'L\'utilisateur a déjà une demande en attente',
    'cannot_accept_others_invitation' => 'Impossible d\'accepter les invitations d\'autres',
    'cannot_decline_others_invitation' => 'Impossible de refuser les invitations d\'autres',
    'cannot_cancel_others_invitation' => 'Impossible d\'annuler les invitations d\'autres',
    'cannot_resend_others_invitation' => 'Impossible de renvoyer les invitations d\'autres',
    'invitation_not_expired' => 'Cette invitation n\'a pas expiré',
    'invitation_resent' => 'Invitation renvoyée avec succès',
    'invitation_cancelled' => 'Invitation annulée',
    'cannot_cancel_others_request' => 'Impossible d\'annuler les demandes d\'autres',
    'request_cancelled' => 'Demande annulée',
    
    // Notifications
    'notification' => [
        'invitation_received' => 'Nouvelle invitation au groupe',
        'invitation_message' => ':inviter vous a invité à rejoindre :group',
        'join_request_received' => 'Nouvelle demande d\'adhésion',
        'join_request_message' => ':user veut rejoindre :group',
        'new_announcement' => 'Nouvelle annonce',
        'announcement_message' => 'Nouvelle annonce dans :group: :title',
    ],
];

