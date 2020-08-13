<?php

namespace App\Http\Controllers\ModuleParc;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\ModuleParc\TechnicalTour;
use Illuminate\Http\Request;

class TechnicalTourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $technicaltour = TechnicalTour::latest()->paginate($request->has('limit') ? $request ->limit : 10);

        return $technicaltour;
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
        
        $technicaltour = TechnicalTour::create($request->all());

        return response()->json($technicaltour, 201);
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
        $technicaltour = TechnicalTour::findOrFail($id);

        return $technicaltour;
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
        
        $technicaltour = TechnicalTour::findOrFail($id);
        $technicaltour->update($request->all());

        return response()->json($technicaltour, 200);
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
        TechnicalTour::destroy($id);

        return response()->json(null, 204);
    }
}
