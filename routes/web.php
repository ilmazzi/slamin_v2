<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', \App\Livewire\Home\HomeIndex::class)->name('home');

// Color System
Route::get('/colors', \App\Livewire\SimpleThemeManager::class)->name('colors');

// Parallax Pages
Route::get('/parallax', function () {
    return view('parallax.index');
})->name('parallax');

Route::get('/parallax-enhanced', function () {
    return view('parallax.enhanced');
})->name('parallax.enhanced');

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

// Resource routes (placeholders)
Route::get('/events', function () {
    return view('pages.events');
})->name('events.index');

Route::get('/poems', function () {
    return view('pages.poems');
})->name('poems.index');

Route::get('/articles', function () {
    return view('pages.articles');
})->name('articles.index');

Route::get('/gallery', function () {
    return view('pages.gallery');
})->name('gallery.index');

// Auth routes (if using Breeze/Jetstream, they would be added here)
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth')->name('dashboard');

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
