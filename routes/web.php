<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Broadcasting Authentication
Broadcast::routes(['middleware' => ['web', 'auth']]);

// Public routes
Route::get('/', \App\Livewire\Home\HomeIndex::class)->name('home');

// Newsletter
Route::get('/newsletter/unsubscribe/{token}', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])
    ->name('newsletter.unsubscribe');

// Global Search
Route::get('/search', \App\Livewire\Search\GlobalSearch::class)->name('search');

// API Like Toggle
Route::post('/api/like/toggle', [App\Http\Controllers\Api\LikeController::class, 'toggle'])
    ->middleware('auth')
    ->name('api.like.toggle');

// API Get Likers
Route::get('/api/like/likers', [App\Http\Controllers\Api\LikeController::class, 'getLikers'])
    ->name('api.like.likers');

Route::post('/api/snaps', [App\Http\Controllers\Api\SnapController::class, 'store'])
    ->middleware('auth')
    ->name('api.snaps.store');

Route::post('/api/videos/{video}/view', [App\Http\Controllers\Api\VideoViewController::class, 'increment'])
    ->name('api.videos.view');

// API Comments
Route::get('/api/comments', [App\Http\Controllers\Api\CommentController::class, 'index'])
    ->name('api.comments.index');
Route::post('/api/comments', [App\Http\Controllers\Api\CommentController::class, 'store'])
    ->middleware('auth')
    ->name('api.comments.store');


// User Search API
Route::get('/api/users/search', [App\Http\Controllers\Api\UserSearchController::class, 'search'])
    ->middleware('auth')
    ->name('api.users.search');

// Check user online status
Route::get('/api/users/{user}/check-online', function(\App\Models\User $user) {
    $onlineService = app(\App\Services\OnlineStatusService::class);
    return response()->json(['online' => $onlineService->isOnline($user->id)]);
})->middleware('auth')->name('api.users.check-online');

// Color System
Route::get('/colors', \App\Livewire\SimpleThemeManager::class)->name('colors');

// Parallax Pages
Route::get('/parallax', function () {
    return view('parallax.index');
})->name('parallax');

Route::get('/parallax-enhanced', function () {
    return view('parallax.enhanced');
})->name('parallax.enhanced');

// Events Routes
Route::get('/events', \App\Livewire\Events\EventsIndex::class)->name('events.index');

// Groups Routes
// Index route is public (no auth required)
Route::get('/groups', \App\Livewire\Groups\GroupIndex::class)->name('groups.index');

// Other groups routes require authentication
Route::middleware('auth')->prefix('groups')->name('groups.')->group(function () {
    Route::get('/create', \App\Livewire\Groups\GroupCreate::class)->name('create');
    Route::get('/{group}/edit', \App\Livewire\Groups\GroupEdit::class)->name('edit');
    
    // Member Management
    Route::prefix('{group}/members')->name('members.')->group(function () {
        Route::get('/', [App\Http\Controllers\GroupMemberController::class, 'index'])->name('index');
        Route::post('/{member}/promote', [App\Http\Controllers\GroupMemberController::class, 'promote'])->name('promote');
        Route::post('/{member}/demote', [App\Http\Controllers\GroupMemberController::class, 'demote'])->name('demote');
        Route::post('/{member}/promote-moderator', [App\Http\Controllers\GroupMemberController::class, 'promoteToModerator'])->name('promote-moderator');
        Route::post('/{member}/demote-member', [App\Http\Controllers\GroupMemberController::class, 'demoteToMember'])->name('demote-member');
        Route::delete('/{member}', [App\Http\Controllers\GroupMemberController::class, 'remove'])->name('remove');
        Route::get('/search', [App\Http\Controllers\GroupMemberController::class, 'searchUsers'])->name('search');
        Route::post('/invite', [App\Http\Controllers\GroupMemberController::class, 'invite'])->name('invite');
    });
    
    // Invitations
    Route::prefix('{group}/invitations')->name('invitations.')->group(function () {
        Route::get('/pending', [App\Http\Controllers\GroupInvitationController::class, 'pending'])->name('pending');
        Route::get('/create', [App\Http\Controllers\GroupInvitationController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\GroupInvitationController::class, 'store'])->name('store');
    });
    
    // Join Requests
    Route::prefix('{group}/requests')->name('requests.')->group(function () {
        Route::get('/pending', [App\Http\Controllers\GroupJoinRequestController::class, 'pending'])->name('pending');
        Route::get('/stats', [App\Http\Controllers\GroupJoinRequestController::class, 'stats'])->name('stats');
        Route::post('/store', [App\Http\Controllers\GroupJoinRequestController::class, 'store'])->name('store');
        Route::post('/{request}/accept', [App\Http\Controllers\GroupJoinRequestController::class, 'accept'])->name('accept');
        Route::post('/{request}/decline', [App\Http\Controllers\GroupJoinRequestController::class, 'decline'])->name('decline');
    });
    
    // Announcements
    Route::prefix('{group}/announcements')->name('announcements.')->group(function () {
        Route::get('/', [App\Http\Controllers\GroupAnnouncementController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\GroupAnnouncementController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\GroupAnnouncementController::class, 'store'])->name('store');
        Route::get('/{announcement}', [App\Http\Controllers\GroupAnnouncementController::class, 'show'])->name('show');
        Route::get('/{announcement}/edit', [App\Http\Controllers\GroupAnnouncementController::class, 'edit'])->name('edit');
        Route::put('/{announcement}', [App\Http\Controllers\GroupAnnouncementController::class, 'update'])->name('update');
        Route::delete('/{announcement}', [App\Http\Controllers\GroupAnnouncementController::class, 'destroy'])->name('destroy');
    });
    
    Route::get('/{group}', \App\Livewire\Groups\GroupShow::class)->name('show');
});

// Routes per inviti (globali)
Route::prefix('group-invitations')->name('group-invitations.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\GroupInvitationController::class, 'index'])->name('index');
    Route::get('/sent', [App\Http\Controllers\GroupInvitationController::class, 'sent'])->name('sent');
    Route::get('/{invitation}', [App\Http\Controllers\GroupInvitationController::class, 'show'])->name('show');
    Route::post('/{invitation}/accept', [App\Http\Controllers\GroupInvitationController::class, 'accept'])->name('accept');
    Route::post('/{invitation}/decline', [App\Http\Controllers\GroupInvitationController::class, 'decline'])->name('decline');
    Route::delete('/{invitation}', [App\Http\Controllers\GroupInvitationController::class, 'cancel'])->name('cancel');
    Route::post('/{invitation}/resend', [App\Http\Controllers\GroupInvitationController::class, 'resend'])->name('resend');
});

// Routes per richieste di partecipazione
Route::prefix('group-requests')->name('group-requests.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\GroupJoinRequestController::class, 'index'])->name('index');
    Route::get('/{request}', [App\Http\Controllers\GroupJoinRequestController::class, 'show'])->name('show');
    Route::delete('/{request}', [App\Http\Controllers\GroupJoinRequestController::class, 'cancel'])->name('cancel');
});

// Media Routes
Route::get('/media', \App\Livewire\Media\MediaIndex::class)->name('media.index');

// Media Upload Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/media/upload/video', \App\Livewire\Media\VideoUpload::class)->name('media.upload.video');
    Route::get('/media/upload/photo', \App\Livewire\Media\PhotoUpload::class)->name('media.upload.photo');
    Route::get('/media/upload-limit', \App\Livewire\Media\UploadLimit::class)->name('media.upload-limit');
    Route::get('/media/my-videos', \App\Livewire\Media\MyVideos::class)->name('media.my-videos');
});

Route::get('/videos/{video}', function(\App\Models\Video $video) {
    return view('pages.video-show', compact('video'));
})->name('videos.show');
Route::get('/photos/{photo}', function(\App\Models\Photo $photo) {
    // Redirect to home with modal open
    return view('pages.photo-redirect', compact('photo'));
})->name('photos.show');

Route::get('/events/create', \App\Livewire\Events\EventCreation::class)
    ->middleware('auth')
    ->name('events.create');

Route::get('/events/{event}', \App\Livewire\Events\EventShow::class)->name('events.show');

Route::get('/events/{event}/edit', \App\Livewire\Events\EventEdit::class)
->middleware('auth')
    ->name('events.edit');

// Event Invitation Routes
Route::middleware('auth')->prefix('event-invitations')->name('event-invitations.')->group(function () {
    Route::post('/{invitation}/accept', [App\Http\Controllers\EventInvitationController::class, 'accept'])->name('accept');
    Route::post('/{invitation}/decline', [App\Http\Controllers\EventInvitationController::class, 'decline'])->name('decline');
});

// Event Scoring Routes
Route::middleware('auth')->prefix('events/{event}/scoring')->name('events.scoring.')->group(function () {
    Route::get('/scores', \App\Livewire\Events\Scoring\ScoreEntry::class)->name('scores');
    Route::get('/participants', \App\Livewire\Events\Scoring\ParticipantManagement::class)->name('participants');
    Route::get('/rankings', \App\Livewire\Events\Scoring\Rankings::class)->name('rankings');
});

// Manage route (da implementare)
Route::get('/events/{event}/manage', function(\App\Models\Event $event) {
    // Check permissions
    if (auth()->user()->id !== $event->organizer_id && !auth()->user()->canOrganizeEvents()) {
        abort(403);
    }
    return view('livewire.events.event-manage', compact('event'));
})->middleware('auth')->name('events.manage');

// Delete Event
Route::delete('/events/{event}', function(\App\Models\Event $event) {
    // Check permissions
    if (auth()->user()->id !== $event->organizer_id && !auth()->user()->hasRole('admin')) {
        abort(403);
    }
    
    // Delete badges awarded from this event
    // Badges are stored in user_badges with metadata containing event info
    $rankings = $event->rankings()->whereNotNull('badge_id')->where('badge_awarded', true)->get();
    foreach ($rankings as $ranking) {
        if ($ranking->participant && $ranking->participant->user_id) {
            // Delete the user_badge entry
            \App\Models\UserBadge::where('user_id', $ranking->participant->user_id)
                ->where('badge_id', $ranking->badge_id)
                ->delete();
        }
    }
    
    // Also delete badges by metadata (source_type = Event)
    \App\Models\UserBadge::where('metadata->source_type', 'App\\Models\\Event')
        ->where('metadata->source_id', $event->id)
        ->delete();
    
    \App\Models\UserBadge::where('metadata->source_type', 'App\\Models\\EventRanking')
        ->whereIn('metadata->source_id', $event->rankings()->pluck('id'))
        ->delete();
    
    // Delete related data
    $event->participants()->delete();
    $event->invitations()->delete();
    $event->rounds()->delete();
    $event->scores()->delete();
    $event->rankings()->delete();
    
    // Delete cover image if exists
    if ($event->cover_image) {
        \Storage::disk('public')->delete($event->cover_image);
    }
    
    $eventTitle = $event->title;
    $event->delete();
    
    return redirect()->route('events.index')->with('success', __('events.manage.event_deleted', ['title' => $eventTitle]));
})->middleware('auth')->name('events.destroy');

// Poems Routes (Livewire)
Route::get('/poems', \App\Livewire\Poems\PoemIndex::class)->name('poems.index');

// Poems CRUD (Auth required) - PRIMA di {slug} per evitare conflitti!
Route::middleware('auth')->group(function () {
    Route::get('/poems/create', \App\Livewire\Poems\PoemCreate::class)->name('poems.create');
    Route::get('/poems/my/poems', \App\Livewire\Poems\MyPoems::class)->name('poems.my-poems');
    Route::get('/poems/my/drafts', \App\Livewire\Poems\MyDrafts::class)->name('poems.drafts');
    Route::get('/poems/my/bookmarks', \App\Livewire\Poems\MyBookmarks::class)->name('poems.bookmarks');
    Route::get('/poems/my/liked', \App\Livewire\Poems\MyLiked::class)->name('poems.liked');
    Route::get('/poems/{slug}/edit', \App\Livewire\Poems\PoemEdit::class)->name('poems.edit');
});

// Poems Show - DOPO le route specifiche
Route::get('/poems/{slug}', \App\Livewire\Poems\PoemShow::class)->name('poems.show');

// Gigs System Routes (Unified: Translations + Events)
Route::middleware('auth')->group(function () {
    // Gigs Index & Show
    Route::get('/gigs', \App\Livewire\Translations\GigIndex::class)->name('gigs.index');
    Route::get('/gigs/{gig}', \App\Livewire\Translations\GigShow::class)->name('gigs.show');
    
    // Translation Workspace
    Route::get('/gigs/applications/{application}/workspace', \App\Livewire\Translations\TranslationWorkspace::class)->name('gigs.workspace');
    
    // Payment Routes
    Route::get('/gigs/applications/{application}/payment', \App\Livewire\Translations\PaymentCheckout::class)->name('gigs.payment.checkout');
    Route::get('/gigs/applications/{application}/payment/success', \App\Livewire\Translations\PaymentSuccess::class)->name('gigs.payment.success');
    
    // Gigs Management
    Route::get('/gigs/{gig}/edit', \App\Livewire\Gigs\GigEdit::class)->name('gigs.edit');
    Route::get('/gigs/{gig}/applications', \App\Livewire\Gigs\ApplicationsManagement::class)->name('gigs.applications');
    
    // My Gigs & Applications
    Route::get('/my-gigs', \App\Livewire\Translations\MyGigs::class)->name('gigs.my-gigs');
    Route::get('/my-applications', \App\Livewire\Translations\MyApplications::class)->name('gigs.my-applications');
    
    // Legacy aliases for backwards compatibility
    Route::get('/translations/gigs', fn() => redirect()->route('gigs.index'));
    Route::get('/translations/gig/{gig}', fn($gig) => redirect()->route('gigs.show', $gig));
    Route::get('/translations/my-gigs', fn() => redirect()->route('gigs.my-gigs'));
    Route::get('/translations/my-applications', fn() => redirect()->route('gigs.my-applications'));
});

// Articles Routes
Route::get('/articles', \App\Livewire\Articles\ArticleIndex::class)->name('articles.index');

Route::get('/articles/create', \App\Livewire\Articles\ArticleCreate::class)
    ->middleware('auth')
    ->name('articles.create');

// Fallback route for article ID (redirects to slug for backward compatibility)
// Must be before the slug route to catch numeric IDs
Route::get('/articles/{id}', function ($id) {
    $article = \App\Models\Article::findOrFail($id);
    if ($article->slug) {
        return redirect()->route('articles.show', $article->slug, 301);
    }
    abort(404);
})->where('id', '[0-9]+');

// Article show route - accepts slug (must be after ID route)
Route::get('/articles/{article:slug}', function (\App\Models\Article $article) {
    return view('pages.article-show', compact('article'));
})->name('articles.show');

Route::get('/articles/{article:slug}/edit', \App\Livewire\Articles\ArticleEdit::class)
    ->middleware('auth')
    ->name('articles.edit');

// Admin Routes - Livewire Components
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard\AdminDashboard::class)
        ->name('dashboard');
    
    // Statistics
    Route::get('/statistics', \App\Livewire\Admin\Statistics\StatisticsPage::class)
        ->name('statistics');
    
    // Users
    Route::get('/users', \App\Livewire\Admin\Users\UserList::class)
        ->name('users.index');
    
    // Moderation
    Route::get('/moderation', \App\Livewire\Admin\Moderation\ModerationIndex::class)
        ->name('moderation.index');
    Route::get('/moderation/reports', \App\Livewire\Moderation\ReportsDashboard::class)
        ->name('moderation.reports');
    
    // Articles
    Route::get('/articles', \App\Livewire\Admin\Articles\ArticleList::class)
        ->name('articles.index');
    Route::get('/articles/layout', \App\Livewire\Admin\ArticleLayoutManager::class)
        ->name('articles.layout');
    
    // Categories
    Route::get('/categories/articles', \App\Livewire\Admin\Categories\ArticleCategoryList::class)
        ->name('categories.articles');
    Route::get('/categories/poems', \App\Livewire\Admin\Categories\PoemCategoryList::class)
        ->name('categories.poems');
    
    // Admin Settings (Main page with all links)
    Route::get('/settings', \App\Livewire\Admin\Settings\AdminSettings::class)
        ->name('settings');
    
    // Settings
    Route::get('/settings/system', \App\Livewire\Admin\Settings\SystemSettings::class)
        ->name('settings.system');
    Route::get('/settings/payment', \App\Livewire\Admin\Settings\PaymentSettings::class)
        ->name('settings.payment');
    Route::get('/settings/upload', \App\Livewire\Admin\Settings\UploadSettings::class)
        ->name('settings.upload');
    Route::get('/settings/social', \App\Livewire\Admin\Settings\SocialSettings::class)
        ->name('settings.social');
    Route::get('/settings/placeholder', \App\Livewire\Admin\Settings\PlaceholderSettings::class)
        ->name('settings.placeholder');
    Route::get('/settings/moderation', \App\Livewire\Admin\Settings\ModerationSettings::class)
        ->name('settings.moderation');
    
    // Payment Accounts
    Route::get('/payments/accounts', \App\Livewire\Admin\Payments\PaymentAccounts::class)
        ->name('payments.accounts');
    
    // Payouts
    Route::get('/payments/payouts', \App\Livewire\Admin\Payments\Payouts::class)
        ->name('payments.payouts');
    
    // Gig Positions
    Route::get('/gigs/positions', \App\Livewire\Admin\Gigs\GigPositionList::class)
        ->name('gigs.positions');
    
    // PeerTube Settings
    Route::get('/settings/peertube', \App\Livewire\Admin\Settings\PeerTubeSettings::class)
        ->name('settings.peertube');
    
    // Help & FAQ Management
    Route::get('/help', \App\Livewire\Admin\Help\HelpManagement::class)
        ->name('help.index');
    
    // Translations (Sito - file PHP in lang/)
    Route::get('/translations', \App\Livewire\Admin\Translations\TranslationManagement::class)
        ->name('translations.index');
    
    // Roles & Permissions
    Route::get('/roles', \App\Livewire\Admin\Roles\RoleManagement::class)
        ->name('roles.index');
    Route::get('/permissions', \App\Livewire\Admin\Permissions\PermissionManagement::class)
        ->name('permissions.index');
    
    // Logs
    Route::get('/logs', \App\Livewire\Admin\Logs\LogList::class)
        ->name('logs.index');
    
    // Carousels
    Route::get('/carousels', \App\Livewire\Admin\Carousels\CarouselList::class)
        ->name('carousels.index');
    Route::post('/carousels/add/{type}/{id}', [\App\Http\Controllers\Admin\CarouselController::class, 'addToCarousel'])
        ->name('carousels.add');
    
    // Subreddits
    Route::get('/subreddits', \App\Livewire\Admin\Subreddits\SubredditList::class)
        ->name('subreddits.index');
    
    // Gamification (già esiste)
    Route::get('/gamification/badges', \App\Livewire\Admin\Gamification\BadgeManagement::class)
        ->name('gamification.badges');
    Route::get('/gamification/user-badges', \App\Livewire\Admin\Gamification\UserBadges::class)
        ->name('gamification.user-badges');
    
    // Newsletter
    Route::get('/newsletter', \App\Livewire\Admin\Newsletter\NewsletterManagement::class)
        ->name('newsletter.index');
    
});

// Gallery Route
Route::get('/gallery', function () {
    return view('pages.gallery');
})->name('gallery.index');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/cookies', function () {
    return view('pages.cookies');
})->name('cookies');

Route::get('/guidelines', function () {
    return view('pages.guidelines');
})->name('guidelines');

Route::get('/help', \App\Livewire\Help\HelpIndex::class)->name('help');
Route::get('/faq', \App\Livewire\Help\FaqIndex::class)->name('faq');
Route::get('/support', \App\Livewire\Support\SupportForm::class)->name('support');

// Test Livewire
Route::get('/test-livewire', function () {
    return view('pages.test-livewire');
})->middleware('auth');

// Dashboard Route
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('auth')->name('dashboard.index');

// Auth Routes - Livewire Components
Route::get('/login', \App\Livewire\Auth\Login::class)
    ->middleware('guest')
    ->name('login');

Route::get('/register', \App\Livewire\Auth\Register::class)
    ->middleware('guest')
    ->name('register');

// Password Reset Routes
Route::get('/forgot-password', \App\Livewire\Auth\ForgotPassword::class)
    ->middleware('guest')
    ->name('password.request');

Route::get('/reset-password/{token}', \App\Livewire\Auth\ResetPassword::class)
    ->middleware('guest')
    ->name('password.reset');

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Email Verification Routes
Route::get('/email/verify', \App\Livewire\Auth\EmailVerificationNotice::class)
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('dashboard.index');
    }
    
    $request->fulfill();
    
    // L'evento Verified dovrebbe essere triggerato automaticamente da fulfill()
    // ma lo dispatchiamo esplicitamente per sicurezza
    event(new \Illuminate\Auth\Events\Verified($request->user()));
    
    return redirect()->route('dashboard.index')
        ->with('success', __('auth.email_verified_success'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('dashboard.index');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', __('auth.verification_link_sent'));
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Resource routes removed - now using proper routes above

Route::get('/feed', function () {
    return view('dashboard.feed');
})->name('feed');

Route::get('/verse', function () {
    return view('verse.index');
})->name('verse');

Route::get('/fluid', function () {
    return view('fluid.index');
})->name('fluid');

// Profile Routes
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', \App\Livewire\Profile\ProfileShow::class)->name('show');
    Route::get('/edit', \App\Livewire\Profile\ProfileEdit::class)->name('edit');
    Route::get('/delete', \App\Livewire\Profile\DeleteAccount::class)->name('delete');
    Route::get('/export', \App\Livewire\Profile\ExportData::class)->name('export');
    Route::get('/export/download', function() {
        $user = auth()->user();
        $service = new \App\Services\UserDataExportService();
        $filePath = $service->generateDownloadableFile($user);
        return \Illuminate\Support\Facades\Storage::disk('local')->download($filePath);
    })->name('export.download');
    Route::get('/languages', \App\Livewire\Profile\LanguageManagement::class)->name('languages');
    Route::get('/badges', \App\Livewire\Profile\MyBadges::class)->name('badges');
    Route::get('/my-media', \App\Livewire\Profile\MyMedia::class)->name('my-media');
});

// Public Profile Routes
Route::get('/user/{user}', \App\Livewire\Profile\ProfileShow::class)->name('user.show');
Route::get('/user/{user}/followers', \App\Livewire\Users\UserFollowers::class)->name('user.followers');
Route::get('/user/{user}/following', \App\Livewire\Users\UserFollowing::class)->name('user.following');

// Logout (simplified - would be handled by auth system)
Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Forum Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Chat Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', \App\Livewire\Chat\ChatIndex::class)->name('index');
    Route::get('/{conversation}', \App\Livewire\Chat\ChatIndex::class)->name('show');
});

// Chat API Routes
Route::middleware(['auth'])->prefix('api/chat')->name('api.chat.')->group(function () {
    Route::post('/typing/start', [App\Http\Controllers\Api\ChatTypingController::class, 'startTyping'])->name('typing.start');
    Route::post('/typing/stop', [App\Http\Controllers\Api\ChatTypingController::class, 'stopTyping'])->name('typing.stop');
    Route::post('/messages/{message}/mark-read', [App\Http\Controllers\Api\ChatMessageController::class, 'markAsRead'])->name('messages.mark-read');
});

/*
|--------------------------------------------------------------------------
| Forum Routes
|--------------------------------------------------------------------------
*/

Route::prefix('forum')->name('forum.')->group(function () {
    // Public forum routes
    Route::get('/', \App\Livewire\Forum\ForumIndex::class)->name('index');
    Route::get('/r/{subreddit:slug}', \App\Livewire\Forum\SubredditShow::class)->name('subreddit.show');
    Route::get('/r/{subreddit:slug}/post/{post}', \App\Livewire\Forum\PostShow::class)->name('post.show');
    
    // Authenticated routes
    Route::middleware('auth')->group(function () {
        // Post creation
        Route::get('/r/{subreddit:slug}/create', \App\Livewire\Forum\CreatePost::class)->name('post.create');
        
        // Subreddit management
        Route::get('/create-subreddit', \App\Livewire\Forum\CreateSubreddit::class)->name('subreddit.create');
        Route::get('/r/{subreddit:slug}/settings', \App\Livewire\Forum\SubredditSettings::class)->name('subreddit.settings');
        
        // Moderation routes
        Route::prefix('r/{subreddit:slug}/mod')->name('mod.')->group(function () {
            Route::get('/queue', \App\Livewire\Forum\Moderation\ModerationQueue::class)->name('queue');
            Route::get('/reports', \App\Livewire\Forum\Moderation\Reports::class)->name('reports');
            Route::get('/bans', \App\Livewire\Forum\Moderation\Bans::class)->name('bans');
            Route::get('/moderators', \App\Livewire\Forum\Moderation\Moderators::class)->name('moderators');
        });
    });
    
    // API-style routes for AJAX actions
    Route::middleware('auth')->prefix('api')->name('api.')->group(function () {
        Route::post('/vote', [App\Http\Controllers\ForumVoteController::class, 'vote'])->name('vote');
        Route::post('/report', [App\Http\Controllers\ForumReportController::class, 'create'])->name('report');
        Route::post('/comment/delete', [App\Http\Controllers\ForumCommentController::class, 'delete'])->name('comment.delete');
        Route::post('/post/lock', [App\Http\Controllers\ForumPostController::class, 'lock'])->name('post.lock');
        Route::post('/post/sticky', [App\Http\Controllers\ForumPostController::class, 'sticky'])->name('post.sticky');
    });
});
