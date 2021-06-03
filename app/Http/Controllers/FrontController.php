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
        return view('front.phase');
    }

    public function games_dataset(){
        return response()->json([
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

    public function slides(Request $request)
    {   
        
        // slide 2 : matches
        $num = 5; 
        $matches_p = Game::with(['homeTeam','awayTeam'])->where('date','<',Carbon::now()->subHours(2)->toDateTimeString())->orderBy('date','desc')->take($num)->get()->sortBy('date'); 
        $matches_n = Game::with(['homeTeam','awayTeam'])->where('date','>',Carbon::now()->subHours(2)->toDateTimeString())->orderBy('date')->take($num)->get(); 
        // $statistics = Match::statistics_group($matches_p);
        // slide 3: points of last $num matches
        $dataset = $this->dataset(); 
        $num = 3; // three matches per day..
        $dataset_delta = array();
        $count = count($dataset[0]['data']);
        foreach($dataset as $data) {
            array_push($dataset_delta, [
                'label' => $data['label'],
                'point' => ( $count-1 > $num ? (end($data['data'])-$data['data'][$count-1-$num]) : end($data['data']))   // array_sum(array_slice($data['data'], 0-$num, $num))
            ]);
        }
        usort($dataset_delta, function ($a,$b){ return $b['point'] <=> $a['point']; }); 
        // slide 4  team standings

        return view('front.slides',[
            'dataset' => $dataset,
            'matches_p'=>$matches_p,
            'matches_n'=>$matches_n,
            'dataset_delta'=>$dataset_delta,
   
            'groups' => Group::orderBy('id')->get(['id','name']),
            'teams' => Team::get(['id', 'name', 'iso', 'group_id']),
            'games' => Game::all(),
            'stadiums' => Stadium::all()       
        ]);
    }

}
