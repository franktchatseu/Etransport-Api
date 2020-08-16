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
        $technicaltour = TechnicalTour::select(
            'technical_tours.*',
            'caracter_tech_ones.registration'
        )
            ->join('caracter_tech_ones', 'technical_tours.car_id', '=', 'caracter_tech_ones.stepper_id')
            ->latest()
            ->paginate($request->has('limit') ? $request->limit : 10);

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
        //$technicaltour = TechnicalTour::findOrFail($id);
        $technicaltour = TechnicalTour::select(
            'technical_tours.*',
            'caracter_tech_ones.registration'
        )
            ->join('caracter_tech_ones', 'technical_tours.car_id', '=', 'caracter_tech_ones.stepper_id')
            ->where('technical_tours.id', '=', $id)
            ->first();

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
