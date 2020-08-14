<?php

namespace App\Http\Controllers\ModuleMaintenance;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ModuleMaintenance\Intervention;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $intervention = Intervention::latest()->paginate($request->has('limit') ? $request ->limit : 10);

        return $intervention;
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
        
        $intervention = Intervention::create($request->all());

        return response()->json($intervention, 201);
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
        $intervention = Intervention::findOrFail($id);

        return $intervention;
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
        
        $intervention = Intervention::findOrFail($id);
        $intervention->update($request->all());

        return response()->json($intervention, 200);
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
        Intervention::destroy($id);

        return response()->json(null, 204);
    }
}
