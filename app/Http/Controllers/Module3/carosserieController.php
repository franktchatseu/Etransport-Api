<?php

namespace App\Http\Controllers\Module3;

use App\Http\Controllers\Controller;
use App\Models\module3\carosserie;
use Illuminate\Http\Request;

class carosserieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = carosserie::orderBy('id','desc')->simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'color' => 'required',
            'description' => 'required',
        ]);

        $carosserie = new carosserie();
        $carosserie->color = $data['color'];
        $carosserie->description = $data['description'];
        $carosserie->save();

        return response()->json($carosserie);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\module3\carosserie  $carosserie
     * @return \Illuminate\Http\Response
     */
    public function show(carosserie $carosserie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\module3\carosserie  $carosserie
     * @return \Illuminate\Http\Response
     */
    public function edit(carosserie $carosserie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\module3\carosserie  $carosserie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $carosserie = carosserie::find($id);
        if (!$carosserie) {
            abort(404, "No carosserie found with id $id");
        }

        $data = $req->except('photo');

       
        if ( $data['color'] ?? null) $carosserie->color = $data['color'];
        if ( $data['description'] ?? null) $carosserie->description = $data['description'];


        $carosserie->update();

        return response()->json($carosserie);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\module3\carosserie  $carosserie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$carosserie = carosserie::find($id)) {
            abort(404, "No carosserie found with id $id");
        }

        $carosserie->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = carosserie::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$carosserie = carosserie::find($id)) {
            abort(404, "No carosserie found with id $id");
        }
        return response()->json($carosserie);
    }

}
