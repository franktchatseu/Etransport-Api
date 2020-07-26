<?php

namespace App\Http\Controllers\Module3;

use App\Http\Controllers\Controller;
use App\Models\module3\mark;
use Illuminate\Http\Request;

class markController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = mark::orderBy('id','desc')->simplePaginate($req->has('limit') ? $req->limit : 15);
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

        $mark = new mark();
        $mark->name = $data['name'];
        $mark->description = $data['description'];
        $mark->save();

        return response()->json($mark);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\module3\mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function show(mark $mark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\module3\mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function edit(mark $mark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\module3\mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $mark = mark::find($id);
        if (!$mark) {
            abort(404, "No mark found with id $id");
        }

        $data = $req->except('photo');

       
        if ( $data['name'] ?? null) $mark->name = $data['name'];
        if ( $data['description'] ?? null) $mark->description = $data['description'];


        $mark->update();

        return response()->json($mark);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\module3\mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$mark = mark::find($id)) {
            abort(404, "No mark found with id $id");
        }

        $mark->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = mark::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$mark = mark::find($id)) {
            abort(404, "No mark found with id $id");
        }
        return response()->json($mark);
    }

}
