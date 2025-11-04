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
Route::get('/events', function () {
    $events = \App\Models\Event::where('status', 'published')
        ->where('is_public', true)
        ->orderBy('start_datetime', 'desc')
        ->paginate(12);
    return view('pages.events-index', compact('events'));
})->name('events.index');

Route::get('/events/{event}', function ($id) {
    $event = \App\Models\Event::findOrFail($id);
    return view('pages.event-show', compact('event'));
})->name('events.show');

// Poems Routes
Route::get('/poems', function () {
    $poems = \App\Models\Poem::where('moderation_status', 'approved')
        ->where('is_public', true)
        ->orderBy('created_at', 'desc')
        ->paginate(12);
    return view('pages.poems-index', compact('poems'));
})->name('poems.index');

Route::get('/poems/{poem}', function ($id) {
    $poem = \App\Models\Poem::findOrFail($id);
    return view('pages.poem-show', compact('poem'));
})->name('poems.show');

// Articles Routes
Route::get('/articles', function () {
    $articles = \App\Models\Article::where('moderation_status', 'approved')
        ->where('is_public', true)
        ->orderBy('created_at', 'desc')
        ->paginate(12);
    return view('pages.articles-index', compact('articles'));
})->name('articles.index');

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

// Dashboard Route
Route::get('/dashboard', function () {
    return redirect('/'); // Redirect to home for now
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
