<?php

namespace App\Http\Controllers\ModuleParc;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ModuleParc\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cargo = Cargo::latest()->paginate($request->has('limit') ? $request ->limit : 10);

        return $cargo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $cargo = Cargo::create($request->all());

        return response()->json($cargo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cargo = Cargo::findOrFail($id);

        return $cargo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $cargo = Cargo::findOrFail($id);
        $cargo->update($request->all());

        return response()->json($cargo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cargo::destroy($id);

        return response()->json(null, 204);
    }
}
