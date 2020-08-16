<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use App\Models\Module2\Affectation;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // $affectation = Affectation::latest()->paginate($request->has('limit') ? $request->limit : 10);
        $affectation = Affectation::select(
            'affectations.*',
            'caracter_tech_ones.registration',
            'general_infos.first_name',
            'general_infos.last_name'
        )
            ->join('caracter_tech_ones', 'affectations.car_id', '=', 'caracter_tech_ones.stepper_id')
            ->join('general_infos', 'affectations.driver_id', '=', 'general_infos.stepper_id')
            ->latest()
            ->paginate($request->has('limit') ? $request->limit : 10);
       
        return $affectation;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->except('photo');

        $this->validate($data, [
            'car_id' => 'required',
            'driver_id' => 'required'
        ]);

        $affectation = new Affectation();
        $affectation->car_id = $data['car_id'];
        $affectation->driver_id = $data['driver_id'];
        $affectation->conveyor_id = $data['conveyor_id'];
        $affectation->remorque = $data['remorque'];
        $affectation->date = $data['date'];
        $affectation->save();

        return response()->json($affectation);
        // return response()->json($request);
        // $affectation = Affectation::create($request->all());
        // return response()->json($affectation, 201);
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
        $affectation = Affectation::findOrFail($id);

        return $affectation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $affectation = Affectation::findOrFail($id);


        $data = $req->except('photo');

        if ($data['car_id'] ?? null) $affectation->car_id = $data['car_id'];
        if ($data['driver_id'] ?? null) $affectation->driver_id = $data['driver_id'];
        if ($data['conveyor_id'] ?? null) $affectation->conveyor_id = $data['conveyor_id'];
        if ($data['remorque'] ?? null) $affectation->remorque = $data['remorque'];
        if ($data['date'] ?? null) $affectation->date = $data['date'];


        $affectation->update();

        //$affectation->update($req->all());

        return response()->json($affectation, 200);
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
        Affectation::destroy($id);

        return response()->json(null, 204);
    }
}
