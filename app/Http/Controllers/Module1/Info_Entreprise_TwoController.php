<?php

namespace App\Http\Controllers\Module1;

use App\Http\Controllers\Controller;
use App\Models\Module1\Info_Entreprise_Two;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Module1\Info_Entreprise_One;
use Illuminate\Support\Facades\Mail;

class Info_Entreprise_TwoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $entrepriseInfo = Info_Entreprise_Two::simplePaginate($request->has('limit') ? $request ->limit : 15);
        return response()->json($entrepriseInfo);
    }

    
  
    public function find($id){
        $entrepriseInfo = Info_Entreprise_Two::where('stepper_main_id',$id)->first();   ;
        if (!$entrepriseInfo) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ENTREPRISE_INFO_TWO_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $entrepriseInfo->image = url($entrepriseInfo->image);

        return response()->json($entrepriseInfo);
    }
    public function store(Request $request)
    {

        $data = $request->all();
        $this->validate($data, [
            'localisation' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'email' => 'required',
            'langue' => 'required',
            'description_services' => 'required',
            'enterprise_mission' => 'required',
            'enterprise_ambition' => 'required',
            'enterprise_value' => 'required',
            'opening_hours' => 'required',
            'enterprise_partner' => 'required',
            'stepper_main_id' => 'required:exists:stepper_mains,id',
        ]);
      
        $entrepriseInfoTwo = new Info_Entreprise_Two();
        $entrepriseInfoTwo->localisation = $data['localisation'];
        $entrepriseInfoTwo->phone1 = $data['phone1'];
        $entrepriseInfoTwo->phone2 = $data['phone2'];
        $entrepriseInfoTwo->email = $data['email'];
        $entrepriseInfoTwo->langue = $data['langue'];
        $entrepriseInfoTwo->description_services = $data['description_services'];
        $entrepriseInfoTwo->enterprise_mission = $data['enterprise_mission'];
        $entrepriseInfoTwo->enterprise_ambition = $data['enterprise_ambition'];
        $entrepriseInfoTwo->enterprise_value = $data['enterprise_value'];
        $entrepriseInfoTwo->opening_hours = $data['opening_hours'];
        $entrepriseInfoTwo->enterprise_partner = $data['enterprise_partner'];
        $entrepriseInfoTwo->stepper_main_id = $data['stepper_main_id'];

        //recuperation de la photo du responsable
         //upload image
         $path = "";
         if(isset($request->image)){
             $file = $request->file('image'); 
             if($file != null){
                 $extension = $file->getClientOriginalExtension();
                 $relativeDestination = "uploads/entrepriseInfoTwo";
                 $destinationPath = public_path($relativeDestination);
                 $safeName = "ImageInfoTwo".time().'.'.$extension;
                 $file->move($destinationPath, $safeName);
                 $path = "$relativeDestination/$safeName";
             }
         }
         $entrepriseInfoTwo->image = $path;
         $entrepriseInfoTwo->save();
        return response()->json($entrepriseInfoTwo);
            
    }

    
    public function update(Request $request, $id)
    {
        //
        
        $entrepriseInfoTwo = Info_Entreprise_Two::where('stepper_main_id',$id)->first();
        if (!$entrepriseInfoTwo) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ENTREPRISE_INFO_TWO_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        
        $data = $request->all();

        if ( $data['localisation']) $entrepriseInfoTwo->localisation = $data['localisation'];
        if ( $data['phone1']) $entrepriseInfoTwo->phone1 = $data['phone1'];
        if ( $data['phone2']) $entrepriseInfoTwo->phone2 = $data['phone2'];
        if ( $data['email']) $entrepriseInfoTwo->email = $data['email'];
        if ( $data['langue']) $entrepriseInfoTwo->langue = $data['langue'];
        if ( $data['description_services']) $entrepriseInfoTwo->description_services = $data['description_services'];
        if ( $data['enterprise_ambition']) $entrepriseInfoTwo->enterprise_ambition = $data['enterprise_ambition'];
        if ( $data['enterprise_value']) $entrepriseInfoTwo->enterprise_value = $data['enterprise_value'];
        if ( $data['opening_hours']) $entrepriseInfoTwo->opening_hours = $data['opening_hours'];
        if ( $data['enterprise_partner']) $entrepriseInfoTwo->enterprise_partner = $data['enterprise_partner'];
           //upload image
           $path = "";
           if(isset($request->image)){
               $file = $request->file('image'); 
               if($file != null){
                   $extension = $file->getClientOriginalExtension();
                   $relativeDestination = "uploads/entrepriseInfoTwo";
                   $destinationPath = public_path($relativeDestination);
                   $safeName = "Image".time().'.'.$extension;
                   $file->move($destinationPath, $safeName);
                   $path = "$relativeDestination/$safeName";
               }
           }
        
        $entrepriseInfoTwo->image = $path;
        $entrepriseInfoTwo->update();

        return response()->json($entrepriseInfoTwo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module1\Info_Entreprise_Two  $info_Entreprise_Two
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $entrepriseInfo = Info_Entreprise_Two::find($id);
        if (!$entrepriseInfo) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ENTREPRISE_INFO_TWO_NOT_FOUND");
            return response()->json($apiError, 404);
        }
    
        $entrepriseInfo->delete();      
        return response()->json();
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'sms' => 'required',
            'subject' => ''
            ]);
  
          //verifier si l'utilisateur existe 
          $email=$request['email'];
          $sms=$request['sms'];
         $subject = $request['subject'];
  
      $info = Info_Entreprise_Two::whereEmail($email)->first();
      if ($info == null) {
        return response()->json([
          'sms' => 'email du info inexistants'
            ], 404);
         }
         //return $info;

      $data = [
        'subject' => $subject,
        'sms' => $sms,
      ];

      $email=$info->email;
      Mail::send('message',$data, function($message) use($email){
        $message->to($email)->subject('Message de E-transport');
        $message->from('echurchvcam@gmail.com','');
      });
      return response()->json($data);
    }
}
