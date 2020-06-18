<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Planification\Planing;
use App\Models\Planification\TypePlaning;
use Illuminate\Http\Request;

class TypePlaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = TypePlaning::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $data = $req->except('photo'); 
        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $typePlaning = new TypePlaning();
        $typePlaning->name = $data['name'];
        $typePlaning->description = $data['description'];
        $typePlaning->save();
        return response()->json($typePlaning);
    }





    public function searchTypePlaning(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);
        $data = TypePlaning::where($req->field, 'like', "%$req->q%")->get();
        return response()->json($data);
    }

    public function find($id)
    {
        if (!$typeplaning = TypePlaning::find($id)) {
            abort(404, "No planing found with id $id");
        }
        return response()->json($typeplaning);
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
     * @param  \App\Models\Planifications\TypePlaning  $typePlaning
     * @return \Illuminate\Http\Response
     */
    public function show(TypePlaning $typePlaning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planifications\TypePlaning  $typePlaning
     * @return \Illuminate\Http\Response
     */
    public function edit(TypePlaning $typePlaning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planifications\TypePlaning  $typePlaning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $data = $req->except('photo');
        $this->validate($data, [
            'description' => 'required',
            'name' => 'required',
        ]);

        if (!$typeplaning = TypePlaning::find($id)) {
            abort(404, "No TypePlaning found with id $id");
        }

        if ( $data['name']) $typeplaning->name = $data['name'];
        if ( $data['description']) $typeplaning->description = $data['description'];
        
        $typeplaning->update();
        return response()->json($typeplaning);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planifications\TypePlaning  $typePlaning
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$typeplaning = TypePlaning::find($id)) {
            abort(404, "No Planing found wiht id $id");
        }

        $typeplaning->delete();
        return response()->json();
    }

    public function findPlaning(Request $req, $id)
    {
        if (!$planing = Planing::whereCategoryId($id)->simplePaginate($req->has('limit') ? $req->limit : 15)) {
            abort(404, "No planing for category with id $id found ");
        }
        return response()->json($planing);
    }
}
