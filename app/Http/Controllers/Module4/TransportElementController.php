<?php

namespace App\Http\Controllers\Module4;

use App\Http\Controllers\Controller;
use App\Models\Module4\TransportElement;
use Illuminate\Http\Request;
use App\Models\APIError;


class TransportElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $transport = TransportElement::simplePaginate($request->has('limit') ? $request ->limit : 15);
        return response()->json($transport);
    }


    public function store(Request $request)
    {
        //
        $data = $request->except('presentation_file ');
        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
            'localisation' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'email' => 'required',
            'function' => 'required',
        ]);
        
        //upload image
        $path = "";
        if(isset($request->presentation_file)){
            $file = $request->file('presentation_file'); 
            if($file != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/TransportElement";
                $destinationPath = public_path($relativeDestination);
                $safeName = "TransportElement".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
            }
        }

        $transport = new TransportElement();
        $transport->name = $data['name'];
        $transport->description = $data['description'];
        $transport->localisation = $data['localisation'];
        $transport->phone1 = $data['phone1'];
        $transport->phone2 = $data['phone2'];
        $transport->email = $data['email'];
        $transport->function = $data['function'];
        $transport->presentation_file = $path;
        $transport->save();
   
        return response()->json($transport);
    }


    public function find($id)
    {
        $transport = TransportElement::find($id);
        if (!$transport) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TransportElement");
            return response()->json($apiError, 404);
        }
            return response()->json($transport);
    }

     
    public function update(Request $request, $id)
    {
        //
        $transport = TransportElement::find($id);
        if (!$transport) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TRANSPORTELEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->all();
        if ( $data['name']) $transport->name = $data['name'];
        if ( $data['description']) $transport->description = $data['description'];
        if ( $data['phone1']) $transport->phone1 = $data['phone1'];
        if ( $data['phone2']) $transport->phone2 = $data['phone2'];
        if ( $data['email']) $transport->email = $data['email'];
        if ( $data['function']) $transport->function = $data['function'];
           //upload image
           $path = "";
           if(isset($request->presentation_file)){
               $file = $request->file('presentation_file'); 
               if($file != null){
                   $extension = $file->getClientOriginalExtension();
                   $relativeDestination = "uploads/TransportElement";
                   $destinationPath = public_path($relativeDestination);
                   $safeName = "TransportElement".time().'.'.$extension;
                   $file->move($destinationPath, $safeName);
                   $path = "$relativeDestination/$safeName";
               }
           }

        if ( $data['presentation_file']) $transport->presentation_file = $path;
        $transport->update();

        return response()->json($transport);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module4\TransportElement  $transportElement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $transport = TransportElement::find($id);
        if (!$transport) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TransportElement_NOT_FOUND");
            return response()->json($apiError, 404);
        }
    
            $transport->delete();      
            return response()->json();
    }
}
