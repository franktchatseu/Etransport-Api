<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\MassShedule;
use Illuminate\Http\Request;
use App\Models\APIError;

class MassSheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *by richie : richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        {
            $data = MassShedule::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'        
        ]);

        $data = MassShedule::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }


    /**
     * Show the form for creating a new resource.
     * by richie : richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = $request->only([
            'context',
            'description',
            'start_date',
            'end_date',
            'day'
        ]);

        $this->validate($data, [
            'context' => 'required|string|min:2',
            'description' => 'min:2',
            'day' => 'min:2',
            'end_date' => 'required',
            'start_date' => 'required',
        ]);

        $massShedule=new MassShedule();
        $massShedule->context=$data['context'];
        $massShedule->day=$data['day'];
        $massShedule->description=$data['description'];
        $massShedule->start_date=$data['start_date'];
        $massShedule->end_date=$data['end_date'];
        

        $massShedule->save();

        return response()->json($massShedule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting\Masshedule  $masshedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $massShedule  = MassShedule::find($id);
        if (!$massShedule) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MASSSHEDULE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->only([
            'context',
            'description',
            'start_date',
            'end_date',
            'day'
        ]);

        $this->validate($data, [
            'day' => '',
            'context' => 'required|min:2',
            'start_date' => '',
            'description' => 'required|min:2',
            'end_date' => '',
        ]);

       if (null!==$data['context']){
        $massShedule->context=$data['context'];
       }
       if (null!==$data['day']){
        $massShedule->day=$data['day'];
       }
       if (null!==$data['description']){
        $massShedule->description=$data['description'];
       }
       if (null!==$data['end_date']){
        $massShedule->end_date=$data['end_date'];
       }
       if (null!==$data['start_date']){
        $massShedule->start_date=$data['start_date'];
       }

       $massShedule->update();

       return response()->json($massShedule);

    }

    /**
     * Remove the specified resource from storage.
     *by richie : richienebou@gmail.com
     * @param  \App\Models\Setting\Masshedule  $masshedule
     * @return \Illuminate\Http\Response
     */

    public function find($id)
    {
        $massShedule  = MassShedule::find($id);
        if (!$massShedule) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MASSSHEDULE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($massShedule);
    }

    public function destroy($id)
    {
        $massShedule  = MassShedule::find($id);
        if (!$massShedule) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MASSSHEDULE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $massShedule->delete();      
        return response()->json();
    }
}

