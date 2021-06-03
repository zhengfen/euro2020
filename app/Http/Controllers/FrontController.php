<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\Team;
use App\Models\Game;
use App\Models\Stadium;
use App\Models\User;
use Carbon\Carbon;


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

    public function predictions()
    {
        $predictions = Auth::user()->predictions;
        return view('front.predictions', [
            'groups' => Group::orderBy('id')->get(['id','name']),
            'teams' => Team::get(['id', 'name', 'iso', 'group_id']),
            'games' => Game::all(),
            'stadiums' => Stadium::all(),
            'predictions' => $predictions,
        ]);
    }

    public function ranking(Request $request)
    {   
        return view('front.ranking', [
        ]);
    }

    public function dataset(){
        $colorArray = array("ff0000","00ff00", "000000", "00b7ef", "800000", "ff6600", "808000", "008080", "0000ff", "666699", "808080", "ff9900", "99cc00", "33cccc", "800080", "ff00ff", "ffcc00", "ffff00", "00ff00", "00ffff", "00ccff", "c0c0c0", "ff99cc", "ffcc99", "ccffcc", "ccffff", "cc99ff", "5877ad", "5da4de", "045def", "a45208", "4e874f", "4d5e10", "4d5e10", "4d5e10", "9e4a10");
        $colorNum = count($colorArray);
        // $users = User::where('status',1)->get(); // for alro
        $users = User::all(); 
        $dataset = array();
        $games = Game::orderBy('date')->get();   
        foreach ($users as $key=>$user) {
            array_push( $dataset, ['label'=>$user->name,'data'=>$user->points($games),'backgroundColor'=>'rgba(0, 0, 0, 0)','borderColor'=>'#'.$colorArray[$key%$colorNum], 'borderWidth'=>1]); 
        } 
        usort($dataset, function ($a,$b){ return end($b['data']) <=> end($a['data']); });   
        return $dataset; 
    }

}
