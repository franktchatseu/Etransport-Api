<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use App\Models\Place\Place;
use Illuminate\Http\Request;
use App\Models\APIError;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Place::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
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
            'type_id' => 'required:exists:punishment_types,id',
            'city_id' => 'required:exists:cities,id'
         ]);


            $place = new Place();
            $place->name = $data['name'];
            $place->description = $data['description'];
            $place->type_id = $data['type_id'];
            $place->city_id = $data['city_id'];
            $place->save();
       
        return response()->json($place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $place = Place::find($id);
        if (!$place) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PLACE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
            'type_id' => 'required:exists:punishment_types,id',
            'city_id' => 'required:exists:cities,id'
        ]);

        
        if ( $data['name']) $place->name = $data['name'];
        if ( $data['description']) $place->description = $data['description'];
        if ( $data['type_id']) $place->type_id = $data['type_id'];
        if ( $data['city_id']) $place->city_id = $data['city_id'];

        
        $place->update();

        return response()->json($place);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::find($id);
        if (!$place) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PLACE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $place->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Place::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $place = Place::find($id);
        if (!$place) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PLACE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($place);
    }
}
