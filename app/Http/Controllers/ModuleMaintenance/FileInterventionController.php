<?php

namespace App\Http\Controllers\ModuleMaintenance;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ModuleMaintenance\FileIntervention;
use Illuminate\Http\Request;

class FileInterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fileintervention = FileIntervention::latest()->paginate($request->has('limit') ? $request ->limit : 10);

        return $fileintervention;
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
        
        $fileintervention = FileIntervention::create($request->all());

        return response()->json($fileintervention, 201);
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
        $fileintervention = FileIntervention::findOrFail($id);

        return $fileintervention;
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
        
        $fileintervention = FileIntervention::findOrFail($id);
        $fileintervention->update($request->all());

        return response()->json($fileintervention, 200);
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
        FileIntervention::destroy($id);

        return response()->json(null, 204);
    }
}
