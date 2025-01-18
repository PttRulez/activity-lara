<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\StravaCallbackController;
use App\Http\Controllers\DiariesController;

Route::middleware('auth')->group(function () {
    Volt::route('/', 'pages.diaries.index')->name('diaries');
    
    Volt::route('/activities', 'pages.activities.index')->name('activities');
    Volt::route('/foods', 'pages.foods.index')->name('foods');
    
    Route::get('/strava-callback', StravaCallbackController::class)->name('strava-callback');
});


Route::view('profile', 'pages.profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
