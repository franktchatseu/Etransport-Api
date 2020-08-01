<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use App\Models\Module2\DrivingPermit;
use Illuminate\Http\Request;
use App\Models\APIError;

class DrivingPermitController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //
        $data = DrivingPermit::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'number' => 'required',
            'stepper_id' => 'required',
            'date_issue' => 'required',
            'place_issue' => 'required'
        ]);

        $driverpermit = new DrivingPermit();
        $driverpermit->number = $data['number'];
        $driverpermit->stepper_id = $data['stepper_id'];
        $driverpermit->date_issue = $data['date_issue'];
        $driverpermit->place_issue = $data['place_issue'];
        $driverpermit->save();
       
        return response()->json($driverpermit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $driverpermit = DrivingPermit::where('stepper_id',$id)->first();;
        if (!$driverpermit) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DRIVING_PERMIT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        return response()->json($driverpermit);
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
        $driverpermit = DrivingPermit::where('stepper_id',$id)->first();
        if (!$driverpermit) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DRIVING_PERMIT_NOT_FOUND");

            return response()->json($apiError, 404);
        }

        $data = $request->all();
        
        if ( $request->number ?? null) $driverpermit->number = $data['number'];
        if ( $request->stepper_id ?? null) $driverpermit->stepper_id = $data['stepper_id'];
        if ( $request->date_issue ?? null) $driverpermit->date_issue = $data['date_issue'];
        if ( $request->place_issue ?? null) $driverpermit->place_issue = $data['place_issue'];
        
        $driverpermit->number = $data['number'];
        $driverpermit->date_issue = $data['date_issue'];
        $driverpermit->place_issue = $data['place_issue'];
        $driverpermit->update();

        return response()->json($driverpermit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driverpermit = DrivingPermit::find($id);
        if (!$driverpermit) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DRIVING_PERMIT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $driverpermit->delete();      
        return response()->json();
    }
}
