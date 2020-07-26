<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use App\Models\Module2\Stepper_Driver;
use Illuminate\Http\Request;
use App\Models\APIError;
use Carbon\Carbon;

class Stepper_DriverController extends Controller
{
    public function index()
    {
        //
    }


    public function store(Request $request)
    {
       //
        $data = $request->all();
        $this->validate($data, [
            'value' => 'required',
            'stepper_main_id' => 'required:exists:stepper_mains,id',

        ]);
      
        $stepper = new Stepper_Driver();
        $stepper->value = $data['value'];
        $stepper->status = 0;
        $stepper->stepper_main_id = $data['stepper_main_id'];
         //on genere le numero unique du stepper lors de la premiere creation
        $datecreation = Carbon::now();
        $number = 'stepper'.'_'.$stepper->value.'_'.'status'.'_'.$stepper->status.$datecreation;
        $stepper->number = $number;
        $stepper->save();
   
        return response()->json($stepper);
    }

    public function find($number)
    {
        $stepper = Stepper_Driver::whereNumber($number)->first();
        if (!$stepper) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("STEPPER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            return response()->json($stepper);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\module3\Stepper_Driver  $Stepper_Driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $number)
    {
        //
        $data = $request->all();
        $this->validate($data, [
            'value' => 'required',
            'status' => 'required',
        ]);
        $stepper = Stepper_Driver::whereNumber($number)->first();
        if (!$stepper) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("STEPPER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        if ( $data['value']) $stepper->value = $data['value'];
        if ( $data['status']) $stepper->status = $data['status'];

        $stepper->update();

        return response()->json($stepper);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\module3\Stepper_Driver  $Stepper_Driver
     * @return \Illuminate\Http\Response
     */
    public function destroy($number)
    {
        //
        $stepper = Stepper_Driver::whereNumber($number)->first();
        if (!$stepper) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("STEPPER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $stepper->delete();      
        return response()->json();
    }
}
