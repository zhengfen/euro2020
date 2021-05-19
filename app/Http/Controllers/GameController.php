<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Stadium;
use App\Models\Group;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $teams = Team::orderBy('name')->get(['id', 'name', 'iso']);
        $stadiums = Stadium::orderBy('name')->get(['id', 'name']);
        $groups = Group::orderBy('id')->get(['id', 'name']);
        return view('games', [
            'teams' => $teams,
            'stadiums' => $stadiums,
            'groups' => $groups
        ]);
    }
    public function index_api(Request $request)
    {
        $games = Game::orderBy('id')->get();
        $data = [
            'games' => $games
        ];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $game = Game::create($request->all());
        $data = [
            'game' => $game
        ];
        return response()->json($data);
    }

    public function update(Request $request, Game $game)
    {
        $game->update($request->all());
        $data = [
            'game' => $game
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
