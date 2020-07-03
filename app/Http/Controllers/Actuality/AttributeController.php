<?php

namespace App\Http\Controllers\Actuality;

use App\Models\APIError;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actuality\Attribute;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Attribute::simplePaginate($req->has('limit') ? $req->limit : 5);
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
            'name' => 'required|unique:attributes',
            'type' => 'required',
        ]);

        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->slug = preg_replace('/[^a-zA-Z0-9_.]/', '', $request->name);
        $attribute->save();
       
        return response()->json($attribute);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute = Attribute::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ATTRIBUTE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return $attribute;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(attribute $attribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ATTRIBUTE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->except('photo');

        $this->validate($data, [
            'name' => 'required',            
        ]);
        
        if ($request->name) $attribute->name = $data['name'];
        if ($request->type) $attribute->type = $data['type'];
        $attribute->update();

        return response()->json($attribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Attribute::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function destroy($id)
    {
        if (!$attribute = Attribute::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ATTRIBUTE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $attribute->delete();      
        return response()->json();
    }

    
}
