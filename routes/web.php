<?php

use App\Http\Controllers\VideoController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Welcome Page (Homepage)
Route::get('/', [VideoController::class, 'index'])->name('welcome');

// Video Routes
Route::middleware('auth')->group(function () {
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
    Route::post('/videos/{video}/like', [VideoController::class, 'like'])->name('videos.like');
    Route::post('/videos/{video}/comments', [CommentController::class, 'store'])->name('videos.comments.store');
});

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/explore', 'pages.explore')->name('explore');

// Authentication Routes
Auth::routes();
