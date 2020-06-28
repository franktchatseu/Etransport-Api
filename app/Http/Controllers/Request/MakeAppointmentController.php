<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\MakingAppointment;
use App\Models\APIError;

/**
     * CRUD of objectMakingAppointment
     * @author tchamou ramses
     * @email tchamouramses@gmail.com
*/

class MakeAppointmentController extends Controller
{
    //

    public function create (Request $request){
        $request->validate([
            'request_hour' => 'required',
            'request_date' => 'required',
            'request_comment' => 'required',
            'object_id' => 'required',
            'person_id' => 'required',
            'state' => 'required|in:PENDING,APPROVED,REJECTED'
        ]);
        
        $data = $request->only([  
            'request_hour', 
            'request_date',
            'request_comment',
            'state',
            'object_id',
            'person_id'
        ]);
        $appointment = MakingAppointment::create($data);
        return response()->json($appointment);
    }

    public function update(Request $request, $id){
        $appointment = MakingAppointment::find($id);
        if($appointment == null){
            $apiError = new APIError();
            $apiError->setStatus("404");
            $apiError->setCode("MakingAppointment_ID_NOT_EXISTING");
            $apiError->setErrors(['id' => 'Making Appointment id not existing']);

            return response()->json($apiError, 404);
        }
        
        $request->validate([
            'state' => 'required|in:PENDING,APPROVED,REJECTED',
        ]);

        $data = $request->only([
            'request_hour', 
            'request_date',
            'request_comment',
            'state',
            'object_id',
            'person_id'
        ]);

        $appointment->update($data);
        return response()->json($appointment);
    }

    public function find($id){
        $appointment = MakingAppointment::find($id);
        if($appointment == null) {
            $unauthorized = new APIError;
            $unauthorized->setStatus("404");
            $unauthorized->setCode("appointment_NOT_FOUND");
            $unauthorized->setMessage("appointment id not existing");

            return response()->json($unauthorized, 404); 
        }

        return response()->json($appointment);
    }

    public function get(Request $request){
        $limit = $request->limit;
        $page = $request->page; 
        $appointments = MakingAppointment::simplePaginate($request->has('limit') ? $req->limit : 15);
        return response()->json($appointments);
    }


    public function delete($id){
        $appointment = MakingAppointment::find($id);
        if($appointment ==null){
            $unauthorized = new APIError;
            $unauthorized->setStatus("404");
            $unauthorized->setCode("appointment_NOT_FOUND");
            $unauthorized->setMessage("No appointment found with id $id");
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

        $data = MakingAppointment::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    } 

    public function findAllForUser(Request $req, $id)
    {
        $evenement = MakingAppointment::wherePerson_id($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($evenement);
    }

}
