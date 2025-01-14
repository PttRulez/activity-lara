<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\StravaCallbackController;

Route::middleware('auth')->group(function () {
    Volt::route('/', 'pages.home')->name('home');
    
    Volt::route('/activities', 'activities.index')->name('activities');
    Volt::route('/foods', 'foods.index')->name('activities');
    
    Route::get('/strava-callback', StravaCallbackController::class)->name('strava-callback');
});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
