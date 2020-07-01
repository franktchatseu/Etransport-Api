<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\ObjectRequestMass;
use App\Models\APIError;

class ObjectRequestMassController extends Controller
{
    //
    
    
    public function create (Request $request){
        $request->validate([
            'label' => 'required'
        ]);

        $data = $request->only([  
            'label', 
            'description'
        ]);

        $object = ObjectRequestMass::create($data);
        return response()->json($object);
    }

    public function update(Request $request, $id){
        $object = ObjectRequestMass::find($id);
        if($object == null){
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ObjectRequestMass_ID_NOT_EXISTING");
            $apiError->setErrors(['id' => 'object id not existing']);

            return response()->json($apiError, 404);
        }
        
        $request->validate([
            'label' => 'required'
        ]);

        $data = $request->only([ 
            'label', 
            'description'
        ]);

        
        $object->update($data);
        return response()->json($object);
    }

    public function find($id){
        $object = ObjectRequestMass::find($id);
        if($object == null) {
            $unauthorized = new APIError;
            $unauthorized->setStatus("404");
            $unauthorized->setCode("object_NOT_FOUND");
            $unauthorized->setMessage("object id not existing");

            return response()->json($unauthorized, 404); 
        }

        return response()->json($object);
    }

    public function get(Request $request){
        $object = ObjectRequestMass::all();
        return response()->json($object);
    }

    public function delete($id){
        $object = ObjectRequestMass::find($id);
        if($object ==null){
            $unauthorized = new APIError;
            $unauthorized->setStatus("404");
            $unauthorized->setCode("object_NOT_FOUND");
            $unauthorized->setMessage("No object found with id $id");
            return response()->json($unauthorized, 404); 
        }
        $object->delete($object);
        return null;
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = ObjectRequestMass::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    }
}
