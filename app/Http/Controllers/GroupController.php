<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function index()
    {
        return view('groups');
    }

    public function index_api(Request $request)
    {
        // return Group::orderBy('id')->get();
        $groups = Group::orderBy('id')->get();
        $data = [
            'groups' => $groups
        ];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $group = Group::create($request->all());
        $data = [
            'group' => $group
        ];
        return response()->json($data);
    }

    public function update(Request $request, Group $group)
    {
        $group->update($request->all());
        $data = [
            'group' => $group
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
