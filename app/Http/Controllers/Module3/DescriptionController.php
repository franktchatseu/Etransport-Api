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
    public function index()
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
        $this->validate($data, [
            'required_workday' => 'required',
            'stepper_id' => 'required',
            'time_required' => 'required',
            'equipment' => 'required',
            'usage' => 'required',
            'usual_location' => 'required',
            'observation' => 'required',
        ]);

        $carpaper = new CarPaper();
        $carpaper->required_workday = $data['required_workday'];
        $carpaper->stepper_id = $data['stepper_id'];
        $carpaper->time_required = $data['time_required'];
        $carpaper->equipment = $data['equipment'];
        $carpaper->usage = $data['usage'];
        $carpaper->usual_location = $data['usual_location'];
        $carpaper->observation = $data['observation'];
        $carpaper->save();
       
        return response()->json($carpaper);
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
        $description = Description::find($id);
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
        $carpaper = Description::find($id);
        if (!$carpaper) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DESCRIPTION_NOT_FOUND");

            return response()->json($apiError, 404);
        }

        $data = $req->all();
        
        if ( $data['required_workday']) $carpaper->required_workday = $data['required_workday'];
        if ( $data['stepper_id']) $carpaper->stepper_id = $data['stepper_id'];
        if ( $data['time_required']) $carpaper->time_required = $data['time_required'];
        if ( $data['equipment']) $carpaper->equipment = $data['equipment'];
        if ( $data['usage']) $carpaper->usage = $data['usage'];
        if ( $data['usual_location']) $carpaper->usual_location = $data['usual_location'];
        if ( $data['observation']) $carpaper->observation = $data['observation'];
        
        $carpaper->required_workday = $data['required_workday'];
        $carpaper->time_required = $data['time_required'];
        $carpaper->equipment = $data['equipment'];
        $carpaper->usage = $data['usage'];
        $carpaper->stepper_id = $data['stepper_id'];
        $carpaper->usual_location = $data['usual_location'];
        $carpaper->observation = $data['observation'];

        $carpaper->update();

        return response()->json($carpaper);
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
