<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\Team;
use App\Models\Game;
use App\Models\Stadium;



class FrontController extends Controller
{
    public function phase()
    {
        return view('front.phase', [
            'groups' => Group::orderBy('id')->get(['id','name']),
            'teams' => Team::get(['id', 'name', 'iso', 'group_id']),
            'games' => Game::all(),
            'stadiums' => Stadium::all()
        ]);
    }

    public function pronostics()
    {
        $pronostics = Auth::user()->pronostics;
        return view('front.pronostics', [
            'groups' => Group::orderBy('id')->get(['id','name']),
            'teams' => Team::get(['id', 'name', 'iso', 'group_id']),
            'games' => Game::all(),
            'stadiums' => Stadium::all(),
            'pronostics' => $pronostics,
        ]);
    }
}
