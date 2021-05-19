<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Group;
use App\Models\Knockout;
use App\Models\Pronostic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PronosticController extends Controller
{
    protected $rules = [
        'team_h' =>'nullable|integer',
        'team_a' =>'nullable|integer',
        'score_h' =>'nullable|integer',
        'score_a' =>'nullable|integer',
        'pen_h' =>'nullable|integer',
        'pen_a' =>'nullable|integer',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $groups = Group::with(['games','teams','games.homeTeam','games.awayTeam','games.stadium'])->get();
        $knockouts = Knockout::with(['games','games.homeTeam','games.awayTeam','games.stadium'])->get();
        $pronostics = Auth::user()->pronostics;
        // construct standings array for all groups
        $standings = Auth::user()->standings($groups);
        return view('pronostics.index',[
            'groups' => $groups,
            'knockouts'=>$knockouts,
            'pronostics'=>$pronostics,
            'page'=>'pronostics',
            'standings'=>$standings,
        ]);
    }
    // get pronostics for the current user and statistics
    public function index_json()
    {
        $pronostics = Auth::user()->pronostics;
//      $games = Game::where('id','<',49)->where('date','<',Carbon::now()->addHours(24))->orderBy('date','asc')->get();
	    $games = Game::where('id','<',49)->where('date','<',Carbon::now()->addHours(48))->orderBy('date','asc')->get();
        $statistics_group = Game::statistics_group($games);
        //return $pronostics;
        return response()->json([
            'pronostics' => $pronostics,
            'statistics_group' => $statistics_group,
            'user'=>Auth::user(),
            'disabled' =>Game::orderBy('date')->first()->date->lt( Carbon::now()->addHours(1)),
        ]);
    }

    // ajax udpate
    public function update(Request $request){
        // check date if updating pronostics is disbaled
        $disabled = Game::orderBy('date')->first()->date->lt( Carbon::now()->addHours(1));
        if ($disabled==true) return;
        //validate
        $game = Game::find($request->game_id);
        $pronostic = Pronostic::firstOrCreate([
            'user_id'=>auth()->id(),
            'game_id'=>$request->game_id
            ]);
        $pronostic->update( $request->only(['score_h', 'score_a', 'team_h', 'team_a']));
        // update knockout teams
        // Auth::user()->update_knockouts();

        return response()->json([
            'pronostic' => $pronostic
        ]);
     }
}
