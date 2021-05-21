<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Group;
use App\Models\Knockout;
use App\Models\Prediction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PredictionController extends Controller
{
    // ajax udpate
    public function update(Request $request){
        // check date if updating predictions is disbaled
        $disabled = Game::orderBy('date')->first()->date->lt( Carbon::now()->addHours(1));
        if ($disabled==true) return;
        //validate
        $game = Game::find($request->game_id);
        $prediction = Prediction::firstOrCreate([
            'user_id'=>auth()->id(),
            'game_id'=>$request->game_id
            ]);
        $prediction->update( $request->only(['score_h', 'score_a', 'team_h', 'team_a']));
        // update knockout teams
        // Auth::user()->update_knockouts();

        return response()->json([
            'prediction' => $prediction
        ]);
     }
}
