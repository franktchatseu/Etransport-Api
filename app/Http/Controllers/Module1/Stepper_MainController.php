<?php

namespace App\Http\Controllers\Module1;

use App\Http\Controllers\Controller;
use App\Models\Module1\Stepper_Main;
use Illuminate\Http\Request;
use App\Models\APIError;
use Carbon\Carbon;



class Stepper_MainController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        ]);
      
        $stepper = new Stepper_Main();
        $stepper->value = $data['value'];
        $stepper->status = 0;
         //on genere le numero unique du stepper lors de la premiere creation
        $datecreation = Carbon::now();
        $number = 'stepper'.'_'.$stepper->value.'_'.'status'.'_'.$stepper->status.$datecreation;
        $stepper->number = $number;
        $stepper->save();
   
        return response()->json($stepper);
    }

    public function find($number)
    {
        $stepper = Stepper_Main::whereNumber($number)->first();
        if (!$stepper) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("STEPPER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            return response()->json($stepper);
    }
    
 
    public function update(Request $request, $number)
    {
        //
        $data = $request->all();
        $this->validate($data, [
            'value' => 'required',
            'status' => 'required',
        ]);
        $stepper = Stepper_Main::whereNumber($number)->first();
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

   
    public function destroy($number)
    {
        //
        $stepper = Stepper_Main::whereNumber($number)->first();
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
