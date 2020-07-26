<?php

namespace App\Http\Controllers\Module3;

use App\Http\Controllers\Controller;
use App\Models\module3\modele;
use Illuminate\Http\Request;

class modelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = modele::orderBy('id','desc')->simplePaginate($req->has('limit') ? $req->limit : 15);
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
    public function store(Request $req)
    {
        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $modele = new modele();
        $modele->name = $data['name'];
        $modele->description = $data['description'];
        $modele->save();

        return response()->json($modele);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\module3\model  $model
     * @return \Illuminate\Http\Response
     */
    public function show(modele $model)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\module3\model  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(modele $model)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\module3\model  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $modele = modele::find($id);
        if (!$modele) {
            abort(404, "No modele found with id $id");
        }

        $data = $req->except('photo');

       
        if ( $data['name'] ?? null) $modele->name = $data['name'];
        if ( $data['description'] ?? null) $modele->description = $data['description'];


        $modele->update();

        return response()->json($modele);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\module3\model  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$modele = modele::find($id)) {
            abort(404, "No modele found with id $id");
        }

        $modele->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = modele::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$modele = modele::find($id)) {
            abort(404, "No modele found with id $id");
        }
        return response()->json($modele);
    }

}
