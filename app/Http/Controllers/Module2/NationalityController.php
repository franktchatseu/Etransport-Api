<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use App\Models\Module2\Nationality;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Nationality::orderBy('id','desc')->simplePaginate($req->has('limit') ? $req->limit : 15);
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

        $Nationality = new Nationality();
        $Nationality->name = $data['name'];
        $Nationality->description = $data['description'];
        $Nationality->save();

        return response()->json($Nationality);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module2\Nationality  $nationality
     * @return \Illuminate\Http\Response
     */
    public function show(Nationality $nationality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module2\Nationality  $nationality
     * @return \Illuminate\Http\Response
     */
    public function edit(Nationality $nationality)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module2\Nationality  $nationality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $Nationality = Nationality::find($id);
        if (!$Nationality) {
            abort(404, "No Nationality found with id $id");
        }

        $data = $req->except('photo');

       
        if ( $data['name'] ?? null) $Nationality->name = $data['name'];
        if ( $data['description'] ?? null) $Nationality->description = $data['description'];


        $Nationality->update();

        return response()->json($Nationality);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module2\Nationality  $nationality
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$Nationality = Nationality::find($id)) {
            abort(404, "No Nationality found with id $id");
        }

        $Nationality->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Nationality::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$Nationality = Nationality::find($id)) {
            abort(404, "No Nationality found with id $id");
        }
        return response()->json($Nationality);
    }

}
