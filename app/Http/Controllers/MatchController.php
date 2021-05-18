<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Team;
use App\Models\Stadium;
use App\Models\Group;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        $teams = Team::orderBy('name')->get(['id', 'name', 'iso']);
        $stadiums = Stadium::orderBy('name')->get(['id', 'name']);
        $groups = Group::orderBy('id')->get(['id', 'name']);
        return view('matches', [
            'teams' => $teams,
            'stadiums' => $stadiums,
            'groups' => $groups
        ]);
    }
    public function index_api(Request $request)
    {
        $matches = Match::orderBy('id')->get();
        $data = [
            'matches' => $matches
        ];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $match = Match::create($request->all());
        $data = [
            'match' => $match
        ];
        return response()->json($data);
    }

    public function update(Request $request, Match $match)
    {
        $match->update($request->all());
        $data = [
            'match' => $match
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        $match->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
