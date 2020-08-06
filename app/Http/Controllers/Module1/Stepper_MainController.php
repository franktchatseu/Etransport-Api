<?php

namespace App\Http\Controllers\Module1;

use App\Http\Controllers\Controller;
use App\Models\Module1\Stepper_Main;
use Illuminate\Http\Request;
use App\Models\APIError;
use Carbon\Carbon;
use App\Models\Module2\General_Info;
use App\Models\module3\caractertechone;





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
        

    //recuperation de tous les chauffeurs et transporteur d'une entreprise donnee
    public function getDriversAndCars(Request $req, $id){

        $stepper = Stepper_Main::find($id);
        if (!$stepper) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("STEPPER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        //recuperation de tous les chauffeurs
        $drivers = General_Info::Select('general_infos.*','nationalities.name as country','stepper_drivers.*','nationalities.description')
        ->join('nationalities','general_infos.nationality_id','=','nationalities.id')
        ->join('stepper_drivers','general_infos.stepper_id','=','stepper_drivers.id')
        ->join('stepper_mains','stepper_drivers.stepper_main_id','=','stepper_mains.id')
        ->where('stepper_drivers.stepper_main_id','=',$id)
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        //recuperation des engins de cet entreprise
        $cars = caractertechone::select('caracter_tech_ones.*','carosseries.color','models.name','marks.name','types.name','models.name as model_name','marks.name as mark_name','types.name as type_name','stepper_trees.*')
        ->join('carosseries','caracter_tech_ones.carosserie_id','=','carosseries.id')
        ->join('models','caracter_tech_ones.model_id','=','models.id')
        ->join('marks','caracter_tech_ones.mark_id','=','marks.id')
        ->join('types','caracter_tech_ones.type_id','=','types.id')
        ->join('stepper_trees','caracter_tech_ones.stepper_id','=','stepper_trees.id')
        ->join('stepper_mains','stepper_trees.stepper_main_id','=','stepper_mains.id')
        ->where('stepper_trees.stepper_main_id','=',$id)
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json([
            
            'drivers'=>$drivers,
            'cars'=> $cars
        ], 200);
    }
     //recuperation de tous les vehicule suivants etat pour un transporteur donnee
     function getCarsByEtat(Request $req,$id, $etat){
              //recuperation des engins de cet entreprise
        $cars = caractertechone::select('caracter_tech_ones.*','caracter_tech_twos.etat','carosseries.color','models.name','marks.name','types.name','models.name as model_name','marks.name as mark_name','types.name as type_name','stepper_trees.*')
        ->join('caracter_tech_twos','caracter_tech_twos.stepper_id','=','caracter_tech_ones.stepper_id')
        ->join('carosseries','caracter_tech_ones.carosserie_id','=','carosseries.id')
        ->join('models','caracter_tech_ones.model_id','=','models.id')
        ->join('marks','caracter_tech_ones.mark_id','=','marks.id')
        ->join('types','caracter_tech_ones.type_id','=','types.id')
        ->join('stepper_trees','caracter_tech_ones.stepper_id','=','stepper_trees.id')
        ->join('stepper_mains','stepper_trees.stepper_main_id','=','stepper_mains.id')
        ->where('caracter_tech_twos.etat','=',$etat)
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($cars);
     }
}
