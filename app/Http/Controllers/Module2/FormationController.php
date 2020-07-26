<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use App\Models\Module2\Formation;
use Illuminate\Http\Request;
use App\Models\APIError;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data = Formation::simplePaginate($request->has('limit') ? $request->limit : 15);
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
            'name' => 'required',
            'stepper_id' => 'required',
            'file' => 'required',
        ]);

        if(isset($request->file)){
            $file = $request->file('file');
            $path = null;
            if($file != null){
                $request->validate(['file'=>'file|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/e-transport/formations/documents";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document_composition".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = url("$relativeDestination/$safeName");
            }
            $data['file'] = $path;
        }

        $formation = new Formation();
        $formation->name = $data['name'];
        $formation->stepper_id = $data['stepper_id'];
        $formation->file = $data['file'];
        $formation->save();
       
        return response()->json($formation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $formation = Formation::find($id);
        if (!$formation) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("FORMATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        return response()->json($formation);
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
        $formation = Formation::find($id);
        if (!$formation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("FORMATION_NOT_FOUND");

            return response()->json($apiError, 404);
        }

        $data = $request->all();
        
        if ( $request->name ?? null) $formation->name = $data['name'];
        if ( $request->stepper_id ?? null) $formation->stepper_id = $data['stepper_id'];
        if ( $request->file ?? null)
        {
            if(isset($request->file)){
                $file = $request->file('file');
                $path = null;

                if($file != null){
                    $request->validate(['file'=>'file|max:20000']);
                    $extension = $file->getClientOriginalExtension();
                    $relativeDestination = "uploads/e-transport/formations/documents";
                    $destinationPath = public_path($relativeDestination);
                    $safeName = "document_information".time().'.'.$extension;
                    $file->move($destinationPath, $safeName);
                    $path = url("$relativeDestination/$safeName");
                    if ($formation->file) {
                        $oldImagePath = public_path($formation->file);
                        if (file_exists($oldImagePath)) {
                            @unlink($oldImagePath);
                        }
                    }
                }

                $data['file'] = $path;
                $formation->file = $data['file'];
            }

        }
        
        $formation->name = $data['name'];
        $formation->stepper_id = $data['stepper_id'];
        $formation->update();

        return response()->json($formation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $formation = Formation::find($id);
        if (!$formation) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("FORMATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $formation->delete();      
        return response()->json();
    }
}
