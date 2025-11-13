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

Route::get('/articles/{article}', function ($id) {
    $article = \App\Models\Article::findOrFail($id);
    return view('pages.article-show', compact('article'));
})->name('articles.show');

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

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', [App\Http\Controllers\AuthController::class, 'processLogin'])
    ->middleware('guest')
    ->name('login.process');

Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');

Route::post('/register', [App\Http\Controllers\AuthController::class, 'processRegistration'])
    ->middleware('guest')
    ->name('register.process');

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

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
