<?php

namespace App\Http\Controllers\Actuality;

use App\Models\APIError;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actuality\Select;

class SelectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Select::simplePaginate($req->has('limit') ? $req->limit : 100);
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
    public function store(Request $request)
    {
        $this->validate($request->all(), [
            'value' => 'required|unique:selects',
            'attribute_id' => 'required'
        ]);

        $Select = new Select();
        $Select->value = $request->value;
        $Select->attribute_id = $request->attribute_id;
        $Select->save();
       
        return response()->json($Select);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\Select  $Select
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $Select = Select::find($id);
        if (!$Select = Select::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Select_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return $Select;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\Select  $Select
     * @return \Illuminate\Http\Response
     */
    public function edit(Select $Select)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Select  $Select
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Select = Select::find($id);
        if (!$Select) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Select_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->except('photo');

        $this->validate($data, [
            'value' => 'required',            
        ]);
        
        if ($request->value) $Select->value = $data['value'];
        $Select->update();

        return response()->json($Select);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\Select  $Select
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Select::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function destroy($id)
    {
        if (!$Select = Select::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Select_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $Select->delete();      
        return response()->json();
    }

    public function findSelects($attribute) {
        $data = Select::whereAttributeId($attribute)
        ->get();
        return response()->json($data);
    }
    
}
