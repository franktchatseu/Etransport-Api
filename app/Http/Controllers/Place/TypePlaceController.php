<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use App\Models\Place\TypePlace;
use Illuminate\Http\Request;

class TypePlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = TypePlace::simplePaginate($req->has('limit') ? $req->limit : 15);
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


            $typePlace = new TypePlace();
            $typePlace->name = $data['name'];
            $typePlace->description = $data['description'];
            $typePlace->save();
       
        return response()->json($typePlace);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place\TypePlace  $typePlace
     * @return \Illuminate\Http\Response
     */
    public function show(TypePlace $typePlace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place\TypePlace  $typePlace
     * @return \Illuminate\Http\Response
     */
    public function edit(TypePlace $typePlace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place\TypePlace  $typePlace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $typePlace = TypePlace::find($id);
        if (!$typePlace) {
            abort(404, "No type of place found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required'
         ]);

        
        if (null !== $data['name']) $typePlace->name = $data['name'];
        if (null !== $data['description']) $typePlace->description = $data['description'];

        
        $typePlace->update();

        return response()->json($typePlace);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place\TypePlace  $typePlace
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$typePlace = TypePlace::find($id)) {
            abort(404, "No type of place found with id $id");
        }

        $typePlace->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = TypePlace::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$typePlace = TypePlace::find($id)) {
            abort(404, "No user found with id $id");
        }
        return response()->json($typePlace);
    }
}