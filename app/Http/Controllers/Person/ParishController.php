<?php

namespace App\Http\Controllers\person;

use App\Http\Controllers\Controller;
use App\Model\Person\parish;
use Illuminate\Http\Request;

class ParishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = parish::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Person\parish  $parish
     * @return \Illuminate\Http\Response
     */
    public function show(parish $parish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Person\parish  $parish
     * @return \Illuminate\Http\Response
     */
    public function edit(parish $parish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Person\parish  $parish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, parish $parish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Person\parish  $parish
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$user = parish::find($id)) {
            abort(404, "No user found with id $id");
        }

        $user->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = parish::where($req->field, 'like', "%$req->q%")
            ->get()->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$user = parish::find($id)) {
            abort(404, "No user found with id $id");
        }
        return response()->json($user);
    }
}
