<?php

namespace App\Http\Controllers\Module1;

use App\Http\Controllers\Controller;
use App\Models\Module1\Info_Entreprise_One;
use Illuminate\Http\Request;
use App\Models\APIError;

class Info_Entreprise_OneController extends Controller
{

    public function index(Request $request)
    {
        //
        $entrepriseInfo = Info_Entreprise_One::simplePaginate($request->has('limit') ? $request ->limit : 15);
        return response()->json($entrepriseInfo);
    }

    public function getAll(Request $request)
    {
        //
        $entrepriseInfo = Info_Entreprise_One::all();
        return response()->json($entrepriseInfo);
    }

    public function findAllInfosEnterprise(Request $request)
    {
        //
        $entrepriseInfo = Info_Entreprise_One::select('info_entreprise_ones.*','info_entreprise_twos.*','stepper_mains.*','info_entreprise_twos.id as info2_id','stepper_mains.id as step_id','info_entreprise_ones.id as info1_id')
                                               ->join('info_entreprise_twos','info_entreprise_ones.stepper_main_id','=','info_entreprise_twos.stepper_main_id')
                                               ->join('stepper_mains','info_entreprise_ones.stepper_main_id','=','stepper_mains.id')
                                               ->simplePaginate($request->has('limit') ? $request ->limit : 15);
                
        //on met la photo du responsable
        foreach( $entrepriseInfo as $entreprise){
            $entreprise->manager_picture = url($entreprise->manager_picture);
        }
        return response()->json($entrepriseInfo);
    }

    public function findAllInfosEnterpriseById(Request $request,$id)
    {
        //
        $entrepriseInfo = Info_Entreprise_One::select('info_entreprise_ones.*','info_entreprise_twos.*')
                                               ->join('info_entreprise_twos','info_entreprise_ones.stepper_main_id','=','info_entreprise_twos.stepper_main_id')
                                               ->where(['info_entreprise_ones.stepper_main_id' => $id])
                                               ->first();

                                               $entrepriseInfo->manager_picture = url($entrepriseInfo->manager_picture);
                                               $entrepriseInfo->image = url($entrepriseInfo->image);

        return response()->json($entrepriseInfo);
    }
    

    public function find($id)
    {
        $entrepriseInfo = Info_Entreprise_One::where('stepper_main_id',$id)->first();
        if (!$entrepriseInfo) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ENTREPRISE_INFO_ONE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $entrepriseInfo->manager_picture = url($entrepriseInfo->manager_picture);
         return response()->json($entrepriseInfo);
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $this->validate($data, [
            'name' => 'required',
            'taxpayer_number' => 'required',
            'rccm_number' => 'required',
            'billing_address' => 'required',
            'gear_number' => 'required',
            'driver_number' => 'required',
            'manager_name' => 'required',
            'manager_function' => 'required',
            'manager_phone' => 'required',
            'stepper_main_id' => 'required:exists:stepper_mains,id',
        ]);
      
        $entrepriseInfo = new Info_Entreprise_One();
        $entrepriseInfo->name = $data['name'];
        $entrepriseInfo->taxpayer_number = $data['taxpayer_number'];
        $entrepriseInfo->rccm_number = $data['rccm_number'];
        $entrepriseInfo->billing_address = $data['billing_address'];
        $entrepriseInfo->gear_number = $data['gear_number'];
        $entrepriseInfo->driver_number = $data['driver_number'];
        $entrepriseInfo->manager_name = $data['manager_name'];
        $entrepriseInfo->manager_function = $data['manager_function'];
        $entrepriseInfo->manager_phone = $data['manager_phone'];
        $entrepriseInfo->stepper_main_id = $data['stepper_main_id'];

        //recuperation de la photo du responsable
         //upload image
         $path = "";
         if(isset($request->manager_picture)){
             $file = $request->file('manager_picture'); 
             if($file != null){
                $request->validate(['manager_picture' => 'image|max:20000']);
                 $extension = $file->getClientOriginalExtension();
                 $relativeDestination = "uploads/EntrepriseInfo";
                 $destinationPath = public_path($relativeDestination);
                 $safeName = "PictureMAnager".time().'.'.$extension;
                 $file->move($destinationPath, $safeName);
                 $path = "$relativeDestination/$safeName";
             }
         }
         $entrepriseInfo->manager_picture = $path;
         $entrepriseInfo->save();
        return response()->json($entrepriseInfo);
    }

  

    public function update(Request $request, $id)
    {
        //
        $entrepriseInfo = Info_Entreprise_One::where('stepper_main_id',$id)->first();
        if (!$entrepriseInfo) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ENTREPRISE_INFO_ONE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        
        $data = $request->all();

        $entrepriseInfo->manager_name = $data['manager_name'];
        $entrepriseInfo->manager_function = $data['manager_function'];
        $entrepriseInfo->manager_phone = $data['manager_phone'];
        $entrepriseInfo->stepper_main_id = $data['stepper_main_id'];

        if ( $data['name']) $entrepriseInfo->name = $data['name'];
        if ( $data['taxpayer_number']) $entrepriseInfo->taxpayer_number = $data['taxpayer_number'];
        if ( $data['rccm_number']) $entrepriseInfo->rccm_number = $data['rccm_number'];
        if ( $data['billing_address']) $entrepriseInfo->billing_address = $data['billing_address'];
        if ( $data['gear_number']) $entrepriseInfo->gear_number = $data['gear_number'];
        if ( $data['driver_number']) $entrepriseInfo->driver_number = $data['driver_number'];
        if ( $data['manager_name']) $entrepriseInfo->manager_name = $data['manager_name'];
        if ( $data['manager_phone']) $entrepriseInfo->manager_phone = $data['manager_phone'];
        if ( $data['stepper_main_id']) $entrepriseInfo->stepper_main_id = $data['stepper_main_id'];
           //upload image
           $path = "";
           if(isset($request->manager_picture)){
               $file = $request->file('manager_picture'); 
               if($file != null){
                $request->validate(['manager_picture' => 'image|max:20000']);
                   $extension = $file->getClientOriginalExtension();
                   $relativeDestination = "uploads/EntrepriseInfo";
                   $destinationPath = public_path($relativeDestination);
                   $safeName = "PictureMAnager".time().'.'.$extension;
                   $file->move($destinationPath, $safeName);
                   $path = "$relativeDestination/$safeName";
               }
           }
        
        $entrepriseInfo->manager_picture = $path;
        $entrepriseInfo->update();

        return response()->json($entrepriseInfo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module1\Info_Entreprise_One  $info_Entreprise_One
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $entrepriseInfo = Info_Entreprise_One::find($id);
        if (!$entrepriseInfo) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ENTREPRISE_INFO_ONE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
    
            $entrepriseInfo->delete();      
            return response()->json();
    }
}
