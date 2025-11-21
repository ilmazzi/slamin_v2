<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', \App\Livewire\Home\HomeIndex::class)->name('home');

// API Like Toggle
Route::post('/api/like/toggle', [App\Http\Controllers\Api\LikeController::class, 'toggle'])
    ->middleware('auth')
    ->name('api.like.toggle');

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

// Media Routes
Route::get('/media', \App\Livewire\Media\MediaIndex::class)->name('media.index');

// Media Upload Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/media/upload/video', \App\Livewire\Media\VideoUpload::class)->name('media.upload.video');
    Route::get('/media/upload-limit', \App\Livewire\Media\UploadLimit::class)->name('media.upload-limit');
    Route::get('/media/my-videos', \App\Livewire\Media\MyVideos::class)->name('media.my-videos');
    // Route::get('/media/upload/photo', \App\Livewire\Media\PhotoUpload::class)->name('media.upload.photo'); // TODO: Da implementare
});

Route::get('/videos/{video}', function(\App\Models\Video $video) {
    return view('pages.video-show', compact('video'));
})->name('videos.show');
Route::get('/photos/{photo}', function(\App\Models\Photo $photo) {
    return view('pages.photo-show', compact('photo'));
})->name('photos.show');

Route::get('/events/create', \App\Livewire\Events\EventCreation::class)
    ->middleware('auth')
    ->name('events.create');

Route::get('/events/{event}', \App\Livewire\Events\EventShow::class)->name('events.show');

Route::get('/events/{event}/edit', \App\Livewire\Events\EventEdit::class)
    ->middleware('auth')
    ->name('events.edit');

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

Route::get('/articles/{article}', function ($id) {
    $article = \App\Models\Article::findOrFail($id);
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
    
    // Users
    Route::get('/users', \App\Livewire\Admin\Users\UserList::class)
        ->name('users.index');
    
    // Moderation
    Route::get('/moderation', \App\Livewire\Admin\Moderation\ModerationIndex::class)
        ->name('moderation.index');
    
    // Articles
    Route::get('/articles', \App\Livewire\Admin\Articles\ArticleList::class)
        ->name('articles.index');
    Route::get('/articles/layout', \App\Livewire\Admin\ArticleLayoutManager::class)
        ->name('articles.layout');
    
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
    
    // Gamification (già esiste)
    Route::get('/gamification/badges', \App\Livewire\Admin\Gamification\BadgeManagement::class)
        ->name('gamification.badges');
    Route::get('/gamification/user-badges', \App\Livewire\Admin\Gamification\UserBadges::class)
        ->name('gamification.user-badges');
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

Route::get('/guidelines', function () {
    return view('pages.guidelines');
})->name('guidelines');

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('/support', function () {
    return view('pages.support');
})->name('support');

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

Route::get('/profile', function () {
    return view('profile.index');
})->middleware('auth')->name('profile');

// Logout (simplified - would be handled by auth system)
Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
})->middleware('auth')->name('logout');
