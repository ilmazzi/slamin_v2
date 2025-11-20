<?php

return [
    'title' => 'Admin Settings',
    'description' => 'Manage all system settings and features from this central page.',
    'sidebar' => 'Admin Settings',
    'menu' => 'Admin Settings',
    
    'sections' => [
        'dashboard' => [
            'title' => 'Dashboard',
            'description' => 'Overview and statistics',
        ],
        'users' => [
            'title' => 'User Management',
            'description' => 'Manage users, roles and permissions',
        ],
        'moderation' => [
            'title' => 'Moderation',
            'description' => 'Content approval and management',
        ],
        'articles' => [
            'title' => 'Article Management',
            'description' => 'Create and manage articles',
        ],
        'carousels' => [
            'title' => 'Carousel Management',
            'description' => 'Manage homepage carousel',
        ],
        'settings' => [
            'title' => 'System Settings',
            'description' => 'General system configuration',
        ],
        'payment_settings' => [
            'title' => 'Payment Settings',
            'description' => 'Payment and fees configuration',
        ],
        'upload_settings' => [
            'title' => 'Upload Settings',
            'description' => 'Upload limits and configuration',
        ],
        'logs' => [
            'title' => 'System Logs',
            'description' => 'View activity and error logs',
        ],
        'gamification' => [
            'title' => 'Gamification',
            'description' => 'Manage badges and user points',
        ],
        'social_settings' => [
            'title' => 'Social Settings',
            'description' => 'Configure likes, comments and notifications',
        ],
        'article_layout' => [
            'title' => 'Article Layout',
            'description' => 'Manage article layout on homepage',
        ],
        'placeholder_settings' => [
            'title' => 'Placeholder Settings',
            'description' => 'Configure placeholder colors',
        ],
        'payment_accounts' => [
            'title' => 'Payment Accounts',
            'description' => 'Manage user Stripe and PayPal accounts',
        ],
        'payouts' => [
            'title' => 'Payouts',
            'description' => 'Manage payments to translators',
        ],
        'gig_positions' => [
            'title' => 'Gig Positions',
            'description' => 'Manage available positions for gigs',
        ],
        'peertube' => [
            'title' => 'PeerTube Settings',
            'description' => 'PeerTube configuration for user videos',
        ],
    ],
    
    'social_settings' => [
        'title' => 'Social Settings',
        'description' => 'Manage social features of the platform',
        'updated_success' => 'Social settings updated successfully',
        'update_error' => 'Error updating social settings',
        'reset' => 'Reset to Default',
        'reset_success' => 'Social settings reset to default values',
    ],
    'placeholder_settings' => [
        'title' => 'Placeholder Settings',
        'description' => 'Manage placeholder colors for poems, articles and events',
        'poem_color' => 'Poem Placeholder Color',
        'article_color' => 'Article Placeholder Color',
        'event_color' => 'Event Placeholder Color',
        'poem_color_required' => 'The color for poems is required',
        'article_color_required' => 'The color for articles is required',
        'color_regex' => 'The color must be a valid hexadecimal code (e.g. #ff0000)',
        'updated_success' => 'Placeholder settings updated successfully',
        'update_error' => 'Error updating placeholder settings',
    ],
    'payment_accounts' => [
        'title' => 'Payment Accounts Management',
        'description' => 'Manage user Stripe and PayPal accounts',
        'total_users' => 'Total Users',
        'stripe_connected' => 'Stripe Connected',
        'paypal_connected' => 'PayPal Connected',
        'pending_verification' => 'Pending Verification',
        'no_paypal_email' => 'User without PayPal email',
        'paypal_verified' => 'PayPal account verified for :name',
        'paypal_unverified' => 'PayPal verification revoked for :name',
        'account_disconnected' => ':type account disconnected for :name',
        'placeholder' => 'List of users with Stripe and PayPal accounts',
    ],
    'payouts' => [
        'title' => 'Payout Management',
        'description' => 'Manage payments to translators',
        'total_payments' => 'Total Payments',
        'pending_payouts' => 'Pending Payouts',
        'total_amount' => 'Total Amount',
        'processed_success' => 'Payout processed successfully',
        'process_error' => 'Error processing payout',
        'processed_all' => 'Processed :success payouts successfully, :failed failed',
        'process_all_error' => 'Error processing all payouts',
        'skipped_by_admin' => 'Payout skipped by admin',
        'skipped_success' => 'Payout skipped',
        'invalid_action' => 'Invalid action',
        'placeholder' => 'List of payouts and payments',
    ],
    'gig_positions' => [
        'title' => 'Gig Positions Management',
        'description' => 'Manage available positions for gigs',
        'create' => 'Create New Position',
        'updated_success' => 'Position updated successfully',
        'created_success' => 'Position created successfully',
        'save_error' => 'Error saving position',
        'cannot_delete_in_use' => 'Cannot delete: position is in use',
        'deleted_success' => 'Position deleted successfully',
        'delete_error' => 'Error deleting position',
        'status_updated' => 'Position status updated',
        'placeholder' => 'List of gig positions',
    ],
    'peertube' => [
        'title' => 'PeerTube Settings',
        'description' => 'Manage PeerTube configuration for user videos',
        'url' => 'PeerTube URL',
        'admin_username' => 'Admin Username',
        'admin_password' => 'Admin Password',
        'test_connection' => 'Test Connection',
        'updated_success' => 'PeerTube settings updated successfully',
        'update_error' => 'Error updating PeerTube settings',
        'connection_success' => 'Connection successful',
        'connection_failed' => 'Connection failed',
        'connection_error' => 'Error testing connection',
    ],
];