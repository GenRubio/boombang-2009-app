<?php

use App\Http\Controllers\Auth\PlayController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

Route::get('/play', [PlayController::class, 'index'])->name('play');