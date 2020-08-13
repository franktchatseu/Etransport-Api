<?php

namespace App\Http\Controllers\Module3;

use App\Http\Controllers\Controller;
use App\Models\module3\caractertechone;
use Illuminate\Http\Request;

class caractertechoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = caractertechone::orderBy('id', 'desc')->simplePaginate($req->has('limit') ? $req->limit : 10);
        return response()->json($data);
    }

    public function findAllCaracter(Request $req)
    {
        $data = caractertechone::select('caracter_tech_ones.*','carosseries.color','models.name','marks.name','types.name','models.name as model_name','marks.name as mark_name','types.name as type_name','stepper_trees.*')
                                 ->join('carosseries','caracter_tech_ones.carosserie_id','=','carosseries.id')
                                 ->join('models','caracter_tech_ones.model_id','=','models.id')
                                 ->join('marks','caracter_tech_ones.mark_id','=','marks.id')
                                 ->join('types','caracter_tech_ones.type_id','=','types.id')
                                 ->join('stepper_trees','caracter_tech_ones.stepper_id','=','stepper_trees.id')
                                 ->orderBy('stepper_id', 'desc')
                                 ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->except('photo');

        $this->validate($data, [
            'registration' => 'required',
            'country_registration' => 'required',
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'volume' => 'required',
            'total_weight' => 'required',
            'live_load' => 'required',
            'empty_weight' => 'required',
            'power' => 'required',
            'chassis_number' => 'required',
            'type_id' => 'required:exists:types,id',
            'mark_id' => 'required:exists:marks,id',
            'model_id' => 'required:exists:models,id',
            'carosserie_id' => 'required:exists:carosseries,id',
            'stepper_id' => 'required:exists:stepper_trees,id',
        ]);

        $caractertechone = new caractertechone();
        $caractertechone->registration = $data['registration'];
        $caractertechone->country_registration = $data['country_registration'];
        $caractertechone->length = $data['length'];
        $caractertechone->width = $data['width'];
        $caractertechone->height = $data['height'];
        $caractertechone->volume = $data['volume'];
        $caractertechone->total_weight = $data['total_weight'];
        $caractertechone->empty_weight = $data['empty_weight'];
        $caractertechone->live_load = $data['live_load'];
        $caractertechone->power = $data['power'];
        $caractertechone->chassis_number = $data['chassis_number'];
        $caractertechone->type_id = $data['type_id'];
        $caractertechone->mark_id = $data['mark_id'];
        $caractertechone->model_id = $data['model_id'];
        $caractertechone->carosserie_id = $data['carosserie_id'];
        $caractertechone->stepper_id = $data['stepper_id'];
        $caractertechone->save();

        return response()->json($caractertechone);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\module3\caractertechone  $caractertechone
     * @return \Illuminate\Http\Response
     */
    public function show(caractertechone $caractertechone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\module3\caractertechone  $caractertechone
     * @return \Illuminate\Http\Response
     */
    public function edit(caractertechone $caractertechone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\module3\caractertechone  $caractertechone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $caractertechone = caractertechone::where('stepper_id',$id)->first();
        if (!$caractertechone) {
            abort(404, "No caractertechone found with id $id");
        }

        $data = $req->except('photo');

        if ($data['registration'] ?? null) $caractertechone->registration = $data['registration'];
        if ($data['country_registration'] ?? null) $caractertechone->country_registration = $data['country_registration'];
        if ($data['length'] ?? null) $caractertechone->length = $data['length'];
        if ($data['width'] ?? null) $caractertechone->width = $data['width'];
        if ($data['height'] ?? null) $caractertechone->height = $data['height'];
        if ($data['volume'] ?? null) $caractertechone->volume = $data['volume'];
        if ($data['total_weight'] ?? null) $caractertechone->total_weight = $data['total_weight'];
        if ($data['live_load'] ?? null) $caractertechone->live_load = $data['live_load'];
        if ($data['power'] ?? null) $caractertechone->power = $data['power'];
        if ($data['chassis_number'] ?? null) $caractertechone->chassis_number = $data['chassis_number'];
        if ($data['type_id'] ?? null)$caractertechone->type_id = $data['type_id'];
        if ($data['mark_id'] ?? null)$caractertechone->mark_id = $data['mark_id'];
        if ($data['model_id'] ?? null)$caractertechone->model_id = $data['model_id'];
        if ($data['carosserie_id'] ?? null)$caractertechone->carosserie_id = $data['carosserie_id'];


        $caractertechone->update();

        return response()->json($caractertechone);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\module3\caractertechone  $caractertechone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$caractertechone = caractertechone::find($id)) {
            abort(404, "No caractertechone found with id $id");
        }

        $caractertechone->delete();
        return response()->json();
    }

    public function search(Request $req)    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = caractertechone::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$caractertechone = caractertechone::where('stepper_id',$id)->first()) {
            abort(404, "No caractertechone found with id $id");
        }
        return response()->json($caractertechone);
    }

    public function findAllCaracterById(Request $req , $id)
    {
        if (!$General_Info = caractertechone::where('stepper_id',$id)->first()) {
            abort(404, "No caractertechone found with id $id");
        }

        $data = caractertechone::select('caracter_tech_ones.*','carosseries.*','models.*','marks.*','types.*','models.name as model_name','marks.name as mark_name','types.name as type_name',
                                 'models.description as model_description','marks.description as mark_description','carosseries.description as carosserie_description','types.description as type_description')
                                ->join('carosseries','caracter_tech_ones.carosserie_id','=','carosseries.id')
                                ->join('models','caracter_tech_ones.model_id','=','models.id')
                                ->join('marks','caracter_tech_ones.mark_id','=','marks.id')
                                ->join('types','caracter_tech_ones.type_id','=','types.id')
                                 ->where(['caracter_tech_ones.stepper_id' => $id])
                                 ->first();
        return response()->json($data);
    }

}
