<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\ParishPatrimony;
use Illuminate\Http\Request;

class ParishPatrimonyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = ParishPatrimony::simplePaginate($req->has('limit')? $req->limit : 15);

        return response()->json($data);
    }
    
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q'=>'description',
            'field'=>'description'
            ]);
    
        $data = ParishPatrimony::where($req->field, 'like',"%$req->q%")->get()->simplePaginate($req->has('limit') ? $req->limit : 15);
    
        return response()->json($data);
    }
    
    public function find($id){
        if(!$ParishPatrimony = ParishPatrimony::find($id)){
            abort(404, "No ParishPatrimony with id $id");
        }
        return response()->json($ParishPatrimony);
    }
        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {

        $this->validate($data, [
            'description'=>'required',
            'value'=>'required'
        ]);
        $parishPatrimony = new ParishPatrimony();
        $parishPatrimony->description = $data['description'];
        $parishPatrimony->value = $data['value'];

        $parishPatrimony->save();

        return response()->json($parishPatrimony);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting\ParishPatrimony  $parishPatrimony
     * @return \Illuminate\Http\Response
     */
    public function show(ParishPatrimony $parishPatrimony)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting\ParishPatrimony  $parishPatrimony
     * @return \Illuminate\Http\Response
     */
    public function edit(ParishPatrimony $parishPatrimony)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting\ParishPatrimony  $parishPatrimony
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParishPatrimony $parishPatrimony, $id)
    {
        $parishPatrimony = ParishPatrimony::find($id);

        if(!$parishPatrimony){
            abort(404, "No parishPatrimony found with id $id");
        }

        $parishPatrimony->update();
        return response()->json($parishPatrimony);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting\ParishPatrimony  $parishPatrimony
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParishPatrimony $parishPatrimony)
    {
        if(!$ParishPatrimony = ParishPatrimony::find($id)){
            abort(404, "No ParishPatrimony with id $id");
        }
        $ParishPatrimony->delete();
        return respose()-json($ParishPatrimony);
    }
}
