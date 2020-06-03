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
    
        $data = ParishPatrimony::where($req->field, 'like',"%$req->q%")->simplePaginate($req->has('limit') ? $req->limit : 15);
    
        return response()->json($data);
    }
    
    public function find($id){
        $parishPatrimony = ParishPatrimony::find($id);
        if (!$parishPatrimony) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHPATRIMONY_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($parishPatrimony);
    }
        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->except('files');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting\ParishPatrimony  $parishPatrimony
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParishPatrimony $parishPatrimony, $id)
    {
        $parishPatrimony = ParishPatrimony::find($id);
        if (!$parishPatrimony) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHPATRIMONY_NOT_FOUND");
            return response()->json($apiError, 404);
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
    public function destroy(ParishPatrimony $parishPatrimony, $id)
    {
        $parishPatrimony = ParishPatrimony::find($id);
        if (!$parishPatrimony) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHPATRIMONY_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $parishPatrimony->delete();
        return response()-json($parishPatrimony);
    }
}
