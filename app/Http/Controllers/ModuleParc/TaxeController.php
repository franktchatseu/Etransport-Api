<?php

namespace App\Http\Controllers\ModuleParc;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ModuleParc\Taxe;
use Illuminate\Http\Request;

class TaxeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $taxe = Taxe::select('taxes.*',
                             'caracter_tech_ones.registration')
                             ->join('caracter_tech_ones','taxes.car_id','=','caracter_tech_ones.stepper_id')
                             ->latest()
                             ->paginate($request->has('limit') ? $request ->limit : 10);

        return $taxe;
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
        
        $taxe = Taxe::create($request->all());

        return response()->json($taxe, 201);
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
       // $taxe = Taxe::findOrFail($id);
        $taxe = Taxe::select('taxes.*',
                                       'caracter_tech_ones.registration')
                                     ->join('caracter_tech_ones','taxes.car_id','=','caracter_tech_ones.stepper_id')
                                     ->where('taxes.id','=',$id)
                                     ->first();
        return $taxe;
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
        
        $taxe = Taxe::findOrFail($id);
        $taxe->update($request->all());

        return response()->json($taxe, 200);
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
        Taxe::destroy($id);

        return response()->json(null, 204);
    }
}
