<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\RequestMass;
use App\Models\APIError;

class RequestMassController extends Controller
{
    public function create (Request $request){
        $request->validate([
            'request_hour' => 'required',
            'request_date' => 'required',
            'place' => 'required',
            'object_id' => 'required',
            'person_id' => 'required',
            'state' => 'required|in:PENDING,APPROVED,REJECTED'
        ]);
        
        $data = $request->only([  
            'request_hour', 
            'request_date',
            'place',
            'state',
            'object_id',
            'person_id'
        ]);
        $appointment = RequestMass::create($data);
        return response()->json($appointment);
    }

    public function update(Request $request, $id){
        $appointment = RequestMass::find($id);
        if($appointment == null){
            $apiError = new APIError();
            $apiError->setStatus("404");
            $apiError->setCode("RequestMass_ID_NOT_EXISTING");
            $apiError->setErrors(['id' => 'RequestMass id not existing']);

            return response()->json($apiError, 404);
        }
        
        $request->validate([
            'state' => 'required|in:PENDING,APPROVED,REJECTED',
        ]);

        $data = $request->only([
            'request_hour', 
            'request_date',
            'place',
            'state',
            'object_id',
            'person_id'
        ]);

        $appointment->update($data);
        return response()->json($appointment);
    }

    public function find($id){
        $appointment = RequestMass::find($id);
        if($appointment == null) {
            $unauthorized = new APIError;
            $unauthorized->setStatus("404");
            $unauthorized->setCode("Request_NOT_FOUND");
            $unauthorized->setMessage("Request mass id not existing");

            return response()->json($unauthorized, 404); 
        }

        return response()->json($appointment);
    }

    public function get(Request $request){
        $limit = $request->limit;
        $page = $request->page; 
        $appointments = RequestMass::simplePaginate($request->has('limit') ? $req->limit : 15);
        return response()->json($appointments);
    }


    public function delete($id){
        $appointment = RequestMass::find($id);
        if($appointment ==null){
            $unauthorized = new APIError;
            $unauthorized->setStatus("404");
            $unauthorized->setCode("Request_NOT_FOUND");
            $unauthorized->setMessage("Request not found with id $id");
            return response()->json($unauthorized, 404); 
        }
        $appointment->delete($appointment);
        return null;
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = RequestMass::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    } 

    public function findAllForUser(Request $req, $id)
    {
        $evenement = RequestMass::wherePerson_id($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Request_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($evenement);
    }
}
