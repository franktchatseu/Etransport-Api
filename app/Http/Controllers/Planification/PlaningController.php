<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Planification\Planing;
use Illuminate\Http\Request;

class PlaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Planing::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $data = $req->except('birth_certificate');
        $this->validate($data, [
            'activity' => 'required',
            'date' => 'required',
            'description' => 'required',
            'nature' => 'required',
            'activityPro' => 'required',
            'type_id' => 'required:exists:type_planings,id'
        ]);
        $planing = new Planing();
        $planing->activity = $data['activity'];
        $planing->date = $data['date'];
        $planing->description = $data['description'];
        $planing->activityPro = $data['activityPro'];
        $planing->place = $data['place'];
        $planing->type_id = $data['type_id'];
        $planing->nature = $data['nature'];

        $planing->save();
        return response()->json($planing);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);
        $data = Planing::where($req->field, 'like', "%$req->q%")->get();
        return response()->json($data);
    }

    public function find($id)
    {
        if (!$planing = Planing::find($id)) {
            abort(404, "No planing found with id $id");
        }
        return response()->json($planing);
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
     * @param  \App\Models\Planification\Planing  $planing
     * @return \Illuminate\Http\Response
     */
    public function show(Planing $planing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification\Planing  $planing
     * @return \Illuminate\Http\Response
     */
    public function edit(Planing $planing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification\Planing  $planing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $data = $req->except('birth_certificate');
        $this->validate($data, [
            'activity' => 'required',
            'date' => 'required',
            'activityPro' => 'required',
        ]);

        $planing = Planing::find($id);
        if (!$planing) {
            abort(404, "No planing found with id $id");
        }

        if ( $data['activity']) $planing->activity = $data['activity'];
        if ( $data['date']) $planing->date = $data['date'];
        if ( $data['description']) $planing->description = $data['description'];
        if ( $data['activityPro']) $planing->activityPro = $data['activityPro'];
        if ( $data['place']) $planing->place = $data['place'];
        if ( $data['type_id']) $planing->type_id = $data['type_id'];
        if ( $data['nature']) $planing->nature = $data['nature'];

        $planing->update();
        return response()->json($planing);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planifications\Planing  $planing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$planing = Planing::find($id)) {
            abort(404, "No Planing found wiht id $id");
        }
        $planing->delete();
        return response()->json();
    }
}
