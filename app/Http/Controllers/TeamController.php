<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return view('teams');
    }

    public function index_api(Request $request)
    {
        // return team::orderBy('id')->get();
        $teams = Team::orderBy('id')->get();
        $data = [
            'teams' => $teams
        ];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $team = Team::create($request->all());
        $data = [
            'team' => $team
        ];
        return response()->json($data);
    }

    public function update(Request $request, Team $team)
    {
        $team->update($request->all());
        $data = [
            'team' => $team
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
