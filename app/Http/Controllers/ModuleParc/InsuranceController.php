<?php

namespace App\Http\Controllers\ModuleParc;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\ModuleParc\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $insurance = Insurance::select('insurances.*',
                                        'caracter_tech_ones.registration',
                                        'transport_elements.name')
                                        ->join('caracter_tech_ones','insurances.car_id','=','caracter_tech_ones.stepper_id')
                                        ->join('transport_elements','insurances.insurer_id','=','transport_elements.id')
                                        ->latest()
                                        ->paginate($request->has('limit') ? $request ->limit : 10);

        return $insurance;
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
        
        $insurance = Insurance::create($request->all());

        return response()->json($insurance, 201);
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
        $insurance = Insurance::findOrFail($id);

        return $insurance;
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
        
        $insurance = Insurance::findOrFail($id);
        $insurance->update($request->all());

        return response()->json($insurance, 200);
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
        Insurance::destroy($id);

        return response()->json(null, 204);
    }
}
