<?php

namespace App\Http\Controllers\ModuleParc;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ModuleParc\MissionOrder;
use Illuminate\Http\Request;

class MissionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $missionorder = MissionOrder::latest()->paginate($request->has('limit') ? $request ->limit : 10);

        return $missionorder;
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
        
        $missionorder = MissionOrder::create($request->all());

        return response()->json($missionorder, 201);
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
        $missionorder = MissionOrder::findOrFail($id);

        return $missionorder;
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
        
        $missionorder = MissionOrder::findOrFail($id);
        $missionorder->update($request->all());

        return response()->json($missionorder, 200);
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
        MissionOrder::destroy($id);

        return response()->json(null, 204);
    }
}
