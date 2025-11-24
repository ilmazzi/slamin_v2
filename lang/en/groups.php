<?php

return [
    // General
    'groups' => 'Groups',
    'group' => 'Group',
    'create_group' => 'Create Group',
    'edit_group' => 'Edit Group',
    'delete_group' => 'Delete Group',
    'my_groups' => 'My Groups',
    'all_groups' => 'All Groups',
    'public_groups' => 'Public Groups',
    'private_groups' => 'Private Groups',
    
    // Group Info
    'name' => 'Name',
    'description' => 'Description',
    'image' => 'Image',
    'visibility' => 'Visibility',
    'public' => 'Public',
    'private' => 'Private',
    'created_by' => 'Created by',
    'created_at' => 'Created at',
    
    // Members
    'members' => 'Members',
    'member' => 'Member',
    'admin' => 'Admin',
    'moderator' => 'Moderator',
    'member_count' => '{0} No members|{1} 1 member|[2,*] :count members',
    
    // Actions
    'join' => 'Join',
    'leave' => 'Leave',
    'request_access' => 'Request Access',
    'invite_members' => 'Invite Members',
    'manage_members' => 'Manage Members',
    
    // Messages
    'group_created' => 'Group created successfully',
    'group_updated' => 'Group updated successfully',
    'group_deleted' => 'Group deleted successfully',
    'joined_successfully' => 'You joined the group successfully',
    'left_successfully' => 'You left the group',
    'request_sent' => 'Access request sent',
    'already_member' => 'You are already a member of this group',
    'request_already_sent' => 'You have already sent an access request',
    'cannot_leave_as_last_admin' => 'You cannot leave the group as the only admin',
    
    // Sections
    'about' => 'About',
    'announcements' => 'Announcements',
    'events' => 'Events',
    'photos' => 'Photos',
    
    // Social
    'website' => 'Website',
    'social_links' => 'Social Links',
    
    // Empty States
    'no_groups' => 'No groups found',
    'no_members' => 'No members',
    'no_announcements' => 'No announcements',
    'no_events' => 'No events',
    
    // Member Management
    'member_promoted' => 'Member promoted to moderator',
    'member_demoted' => 'Moderator demoted to member',
    'member_removed' => 'Member removed from group',
    'cannot_remove_admin' => 'Cannot remove an admin',
    'user_already_member' => 'User is already a member',
    
    // Invitations
    'invitation_sent' => 'Invitation sent successfully',
    'invitation_accepted' => 'Invitation accepted',
    'invitation_declined' => 'Invitation declined',
    'invitation_already_sent' => 'Invitation already sent to this user',
    'invitation_not_valid' => 'Invalid invitation',
    'invitation_expired' => 'Invitation expired',
    
    // Join Requests
    'request_approved' => 'Request approved',
    'request_declined' => 'Request declined',
    'request_not_valid' => 'Invalid request',
    
    // Announcements
    'announcement_created' => 'Announcement created successfully',
    'announcement_updated' => 'Announcement updated successfully',
    'announcement_deleted' => 'Announcement deleted successfully',
    'no_permission_view_announcements' => 'You don\'t have permission to view announcements',
    'no_permission_view_announcement' => 'You don\'t have permission to view this announcement',
    'no_permission_create_announcement' => 'You don\'t have permission to create announcements',
    'no_permission_edit_announcement' => 'You don\'t have permission to edit this announcement',
    'no_permission_delete_announcement' => 'You don\'t have permission to delete this announcement',
    
    // Permissions
    'no_permission_view_members' => 'You don\'t have permission to view members',
    'no_permission_invite' => 'You don\'t have permission to invite users',
    'no_permission_view_invitations' => 'You don\'t have permission to view invitations',
    'no_permission_view_invitation' => 'You don\'t have permission to view this invitation',
    'no_permission_view_requests' => 'You don\'t have permission to view requests',
    'no_permission_view_request' => 'You don\'t have permission to view this request',
    'no_permission_accept_requests' => 'You don\'t have permission to accept requests',
    'no_permission_decline_requests' => 'You don\'t have permission to decline requests',
    'no_permission_view_stats' => 'You don\'t have permission to view statistics',
    
    // Additional Messages
    'already_admin' => 'User is already admin',
    'not_admin' => 'User is not admin',
    'cannot_demote_last_admin' => 'Cannot demote the last admin',
    'already_moderator' => 'User is already moderator',
    'not_moderator' => 'User is not moderator',
    'promoted_to_moderator' => 'User promoted to moderator',
    'demoted_to_member' => 'User demoted to member',
    'cannot_remove_yourself' => 'You cannot remove yourself',
    'cannot_remove_last_admin' => 'Cannot remove the last admin',
    'user_has_pending_request' => 'User already has a pending request',
    'cannot_accept_others_invitation' => 'Cannot accept others\' invitations',
    'cannot_decline_others_invitation' => 'Cannot decline others\' invitations',
    'cannot_cancel_others_invitation' => 'Cannot cancel others\' invitations',
    'cannot_resend_others_invitation' => 'Cannot resend others\' invitations',
    'invitation_not_expired' => 'This invitation has not expired',
    'invitation_resent' => 'Invitation resent successfully',
    'invitation_cancelled' => 'Invitation cancelled',
    'cannot_cancel_others_request' => 'Cannot cancel others\' requests',
    'request_cancelled' => 'Request cancelled',
    
    // Notifications
    'notification' => [
        'invitation_received' => 'New group invitation',
        'invitation_message' => ':inviter invited you to join :group',
        'invitation_response' => 'Invitation response',
        'invitation_accepted_message' => ':user accepted your invitation to :group',
        'invitation_declined_message' => ':user declined your invitation to :group',
        'join_request_received' => 'New join request',
        'join_request_message' => ':user wants to join :group',
        'request_response' => 'Request response',
        'request_accepted_message' => 'Your request to join :group has been accepted',
        'request_declined_message' => 'Your request to join :group has been declined',
        'new_announcement' => 'New announcement',
        'announcement_message' => 'New announcement in :group: :title',
    ],
];

