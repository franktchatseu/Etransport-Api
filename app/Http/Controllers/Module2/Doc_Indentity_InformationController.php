<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use App\Models\Module2\Doc_Indentity_Information;
use Illuminate\Http\Request;
use App\Models\APIError;

class Doc_Indentity_InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $doc = Doc_Indentity_Information::simplePaginate($request->has('limit') ? $request ->limit : 15);
        return response()->json($doc);
    }

    
    public function store(Request $request)
    {
        
        $data = $request->all();
        $this->validate($data, [
            'identical_piece' => 'required',
            'piece_number' => 'required',
            'date_issue' => 'required',
            'place_issue' => 'required',
            'stepper_id' => 'required:exists:stepper_drivers,id',
        ]);
      
        $doc = new Doc_Indentity_Information();
        $doc->identical_piece = $data['identical_piece'];
        $doc->piece_number = $data['piece_number'];
        $doc->date_issue = $data['date_issue'];
        $doc->place_issue = $data['place_issue'];
        $doc->stepper_id = $data['stepper_id'];
        $doc->save();
   
        return response()->json($doc);
   }
    
   public function find($id)
    {
        $doc = Doc_Indentity_Information::find($id);
        if (!$doc) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Doc_Indentity_Information");
            return response()->json($apiError, 404);
        }
            return response()->json($doc);
    }

    public function update(Request $request,$id)
    {
        //
         $DOC = Doc_Indentity_Information::find($id);
         if (!$DOC) {
             $apiError = new APIError;
             $apiError->setStatus("404");
             $apiError->setCode("DOC_IDENTITY_INFORMATION_NOT_FOUND");
             return response()->json($apiError, 404);
         }
 
         $data = $request->all();
         if ( $data['identical_piece']) $DOC->identical_piece = $data['identical_piece'];
         if ( $data['piece_number']) $DOC->piece_number = $data['piece_number'];
         if ( $data['date_issue']) $DOC->date_issue = $data['date_issue'];
         if ( $data['place_issue']) $DOC->place_issue = $data['place_issue'];
         if ( $data['stepper_id']) $DOC->stepper_id = $data['stepper_id'];

         $DOC->update();
 
         return response()->json($DOC);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module2\Doc_Indentity_Information  $doc_Indentity_Information
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $doc = Doc_Indentity_Information::find($id);
        if (!$doc) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("DOC_IDENTITY_INFORMATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            $doc->delete();      
            return response()->json();
    }
}
