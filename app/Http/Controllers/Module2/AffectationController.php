<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use App\Http\Requests;

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
        $affectation = Affectation::latest()->paginate($request->has('limit') ? $request ->limit : 10);

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
            'car_id'=>'required',
            'driver_id'=>'required'
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
    public function update(Request $request, $id)
    {
        
        $affectation = Affectation::findOrFail($id);
        $affectation->update($request->all());

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
