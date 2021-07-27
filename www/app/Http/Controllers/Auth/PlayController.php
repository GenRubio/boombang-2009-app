<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayController extends Controller
{
    public function index()
    {
        return view('game.play');
    }

    public function fullScreen(Request $request)
    {
        return view('game.play-full-screen', ['width' => $request->width, 'height' => $request->height]);
    }

    public function setScreen(Request $request)
    {
        $width = $request->width;
        $height = $request->height;

        return response()->json([
            'content' => view('components.play-full-screen-button', ['width' => $width, 'height' => $height])->render(),
        ], Response::HTTP_CREATED);
    }
}
