<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stadium;

class StadiumController extends Controller
{
    public function index()
    {
        return view('stadiums');
    }

    public function index_api(Request $request)
    {
        // return Stadium::orderBy('id')->get();
        $stadiums = Stadium::orderBy('id')->get();
        $data = [
            'stadiums' => $stadiums
        ];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $stadium = Stadium::create($request->all());
        $data = [
            'stadium' => $stadium
        ];
        return response()->json($data);
    }

    public function update(Request $request, Stadium $stadium)
    {
        $stadium->update($request->all());
        $data = [
            'stadium' => $stadium
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stadium $stadium)
    {
        $stadium->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
