<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function index(){
        return view('game.play');
    }

    public function hullHd(){
        return view('game.play-full-hd');
    }
}
