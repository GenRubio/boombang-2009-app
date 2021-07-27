<?php

use App\Http\Controllers\Auth\PlayController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

Route::get('/play', [PlayController::class, 'index'])
    ->name('play');
Route::get('/play-set-screen', [PlayController::class, 'setScreen'])
    ->name('set.screen');
Route::get('/play-full-screen/{height}/{width}', [PlayController::class, 'fullScreen'])
    ->name('play.full.screen');
