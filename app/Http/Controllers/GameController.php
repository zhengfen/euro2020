<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Stadium;
use App\Models\Group;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function update_statistics(){
        
        $games = Game::where('type', 0)->get(['id']);
        foreach ($games as $game){
            $predictions = Prediction::where('game_id', $game->id)->get(['score_h', 'score_a']); 
            $total = $predictions->count(); 
            $winner_h = $predictions->filter(function ($value, $key) {
                return $value->score_h > $value->score_a; 
            })->count(); 
            $winner_a = $predictions->filter(function ($value, $key) {
                return $value->score_h < $value->score_a; 
            })->count(); 
            $game->percent_h = round($winner_h * 100 / $total); 
            $game->percent_a = round($winner_a * 100 / $total); 
            $game->save(); 
        }        

        $games = Game::where('type', '>', 0)->get(['id', 'team_h', 'team_a', 'type']); 
        foreach ($games as $game){
            $total = Prediction::where('game_id', $game->id)->count();
            
            if ($game->team_h){
                $count = DB::table('games')->join('predictions', 'predictions.game_id','=', 'games.id')
                ->where('games.type', $game->type)->where(function($query) use ($game) {
                    $query->where('predictions.team_h', $game->team_h)
                    ->orWhere('predictions.team_a', $game->team_h); 
                })->count(); 
                $game->percent_h = round($count * 100 / $total); 
            }

            if ($game->team_a){
                $count = DB::table('games')->join('predictions', 'predictions.game_id','=', 'games.id')
                ->where('games.type', $game->type)->where(function($query) use ($game) {
                    $query->where('predictions.team_h', $game->team_a)
                    ->orWhere('predictions.team_a', $game->team_a); 
                })->count(); 
                $game->percent_a = round($count * 100 / $total); 
            }

            $game->save(); 
            
        }
    }

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
