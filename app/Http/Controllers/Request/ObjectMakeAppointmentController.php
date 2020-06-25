<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Request\ObjectMakingAppointment;

class ObjectMakeAppointmentController extends Controller
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

        $object = ObjectMakingAppointment::create($data);
        return response()->json($object);
    }

    public function update(Request $request, $id){
        $object = ObjectMakingAppointment::find($id);
        if($object == null){
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ObjectMakingAppointment_ID_NOT_EXISTING");
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
        $object = ObjectMakingAppointment::find($id);
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
        $object = ObjectMakingAppointment::all();
        return response()->json($object);
    }

    public function delete($id){
        $object = ObjectMakingAppointment::find($id);
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

        $data = ObjectMakingAppointment::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    }
}
