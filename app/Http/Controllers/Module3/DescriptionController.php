<?php

namespace App\Http\Controllers\Module3;

use App\Http\Controllers\Controller;
use App\Models\Module3\Description;
use Illuminate\Http\Request;
use App\Models\APIError;

class DescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //
        $data = Description::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $this->validate($data, [
            'required_workday' => 'required',
            'stepper_id' => 'required',
            'time_required' => 'required',
            'equipment' => 'required',
            'usage' => 'required',
            'usual_location' => 'required',
            'observation' => 'required',
        ]);

        $description = new Description();
        $description->required_workday = $data['required_workday'];
        $description->stepper_id = $data['stepper_id'];
        $description->time_required = $data['time_required'];
        $description->equipment = $data['equipment'];
        $description->usage = $data['usage'];
        $description->usual_location = $data['usual_location'];
        $description->observation = $data['observation'];
        $description->owner = $data['owner'];
        $description->save();
       
        return response()->json($description);
    }

    /**
     * Search the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Description::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Bill the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $description = Description::where('stepper_id',$id)->first();
        if (!$description) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DESCRIPTION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        return response()->json($description);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $description = Description::where('stepper_id',$id)->first();
        if (!$description) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DESCRIPTION_NOT_FOUND");

            return response()->json($apiError, 404);
        }

        $data = $request->all();
        
        if ( $data['required_workday'] ?? null) $description->required_workday = $data['required_workday'];
        if ( $data['time_required'] ?? null) $description->time_required = $data['time_required'];
        if ( $data['equipment'] ?? null) $description->equipment = $data['equipment'];
        if ( $data['usage'] ?? null) $description->usage = $data['usage'];
        if ( $data['usual_location'] ?? null ) $description->usual_location = $data['usual_location'];
        if ( $data['observation'] ?? null) $description->observation = $data['observation'];
        
        $description->required_workday = $data['required_workday'];
        $description->time_required = $data['time_required'];
        $description->equipment = $data['equipment'];
        $description->usage = $data['usage'];
        $description->usual_location = $data['usual_location'];
        $description->observation = $data['observation'];

        $description->update();

        return response()->json($description);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $description = Description::find($id);
        if (!$description) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DESCRIPTION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $description->delete();      
        return response()->json();
    }
}
