<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter; 
use App\Livewire\Moviedb; 

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/moviedb', Moviedb::class)->name('moviedb');
