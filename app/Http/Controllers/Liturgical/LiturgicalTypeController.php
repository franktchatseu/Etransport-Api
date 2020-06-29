<?php

namespace App\Http\Controllers\Liturgical;

use App\Http\Controllers\Controller;
use App\Models\Liturgical\LiturgicalType;
use Illuminate\Http\Request;

class LiturgicalTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = LiturgicalType::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'title' => 'required',
            'description' => 'required',
            'slug' => 'required'
         ]);

            $liturgicalType = new LiturgicalType();
            $liturgicalType->title = $data['title'];
            $liturgicalType->slug = $data['slug'];
            $liturgicalType->description = $data['description'];
             $liturgicalType->save();
       
        return response()->json($liturgicalType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liturgical\LiturgicalType  $liturgicalType
     * @return \Illuminate\Http\Response
     */
    public function show(LiturgicalType $liturgicalType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liturgical\LiturgicalType  $liturgicalType
     * @return \Illuminate\Http\Response
     */
    public function edit(LiturgicalType $liturgicalType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liturgical\LiturgicalType  $liturgicalType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $liturgicalType = LiturgicalType::find($id);
        if (!$liturgicalType) {
            abort(404, "No liturgical Type found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required'
         ]);
        
        if ( $data['title']) $liturgicalType->title = $data['title'];
        if ( $data['description']) $liturgicalType->description = $data['description'];
        
        $liturgicalType->update();

        return response()->json($liturgicalType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liturgical\LiturgicalType  $liturgicalType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$liturgicalType = LiturgicalType::find($id)) {
            abort(404, "No liturgical Type found with id $id");
        }

        $liturgicalType->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = LiturgicalType::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$liturgicalType = LiturgicalType::find($id)) {
            abort(404, "No liturgical type found with id $id");
        }
       return response()->json($liturgicalType);
    }
}
