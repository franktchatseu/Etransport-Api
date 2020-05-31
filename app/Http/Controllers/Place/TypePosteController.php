<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use App\Models\Place\TypePoste;
use Illuminate\Http\Request;
use App\Models\Place\Poste;

class TypePosteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $req)
    { {
            $data = TypePoste::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = TypePoste::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = $request->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'name' => 'required|min:2',
            'description' => 'string|min:4'
        ]);

        $typePoste = new  TypePoste();
        $typePoste->description = $data['description'];
        $typePoste->name = $data['name'];

        $typePoste->save();

        return response()->json($typePoste);
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
     * @param  \App\Models\Place\TypePoste  $typePoste
     * @return \Illuminate\Http\Response
     */
    public function show(TypePoste $typePoste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place\TypePoste  $typePoste
     * @return \Illuminate\Http\Response
     */
    public function edit(TypePoste $typePoste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place\TypePoste  $typePoste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $typePoste = TypePoste::find($id);
        if (!$typePoste) {
            abort(404, "No typePoste found with id $id");
        }

        $data = $request->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'description' => 'string|min:4',
            'name' => 'required|min:2'
        ]);

        if (null !== $data['name']) {
            $typePoste->name = $data['name'];
        }
        if (null !== $data['description']) {
            $typePoste->description = $data['description'];
        }


        $typePoste->update();

        return response()->json($typePoste);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place\TypePoste  $typePoste
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        if (!$typePoste = TypePoste::find($id)) {
            abort(404, "No typePoste  found with id $id");
        }
        return response()->json($typePoste);
    }

    public function findPostes(Request $req, $id)
    {
        $postes = Poste::whereTypePosteId($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($postes);
    }

    public function destroy($id)
    {
        if (!$typePoste  = TypePoste::find($id)) {
            abort(404, "No typePoste  found with id $id");
        }

        $typePoste->delete();
        return response()->json();
    }
}
