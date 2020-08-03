<?php

namespace App\Http\Controllers\Module3;

use App\Http\Controllers\Controller;
use App\Models\module3\type;
use Illuminate\Http\Request;

class typeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = type::orderBy('id','desc')->simplePaginate($req->has('limit') ? $req->limit : 5);
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

        $type = new type();
        $type->name = $data['name'];
        $type->description = $data['description'];
        $type->save();

        return response()->json($type);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\module3\type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\module3\type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\module3\type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $type = type::find($id);
        if (!$type) {
            abort(404, "No type found with id $id");
        }

        $data = $req->except('photo');

       
        if ( $data['name'] ?? null) $type->name = $data['name'];
        if ( $data['description'] ?? null) $type->description = $data['description'];


        $type->update();

        return response()->json($type);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\module3\type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$type = type::find($id)) {
            abort(404, "No type found with id $id");
        }

        $type->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = type::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$type = type::find($id)) {
            abort(404, "No type found with id $id");
        }
        return response()->json($type);
    }

}
