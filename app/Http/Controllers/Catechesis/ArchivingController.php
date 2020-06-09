<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Archiving;
use Illuminate\Http\Request;
use App\Models\APIError;

class ArchivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Archiving::simplePaginate($req->has('limit') ? $req->limit : 15);
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
        $data = $request->except('photo');

        $this->validate($data, [
            'motif' => 'required',
            'description' => 'required',
            'catechesis_id'=> 'required'
        ]);
        
        $filePaths = $this->uploadMultipleFiles($request, 'files', 'archivings', ['file', 'mimes:pdf,doc,ppt,xls,rtf,jpg,png']);
        $data['files'] = json_encode($filePaths);

        $archiv = new Archiving();
        $archiv->motif = $data['motif'];
        $archiv->description = $data['description'];
        $archiv->catechesis_id = $data['catechesis_id'];
        $archiv->files = $data['files'];
        $archiv->save();
              
        return response()->json($archiv);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\Archiving  $archiving
     * @return \Illuminate\Http\Response
     */

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Archiving::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $archiv = Archiving::find($id);
        if (!$archiv) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ARCHIV_NOT_FOUND");
            return response()->json($apiError, 404);
        }  


        $data =$req->all();

        $this->validate($data, [
            'motif' => 'required',
            'description' => 'required',
            'catechesis_id'=>'required'
        ]); 
        if(isset($req->files)){
            $file = $req->file('files');
            $path = null;
            if($file != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/permissions";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
            }
            $data['files'] = $path;     
        }
            //dd($path);
            $archiv = new Archiving();
            $archiv->motif = $data['motif'];
            $archiv->description = $data['description'];
            $archiv->catechesis_id = $data['catechesis_id'];
            $archiv->files = $path;
            $archiv->save(); 

        $archiv->update();
        return response()->json($archiv);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catechesis\Archiving  $archiving
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $archiv = Archiving::find($id);
        if (!$archiv) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ARCHIV_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $archiv->delete();      
        return response()->json();
    }

    public function find($id)
    {
        $archiv = Archiving::find($id);
        if (!$archiv) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ARCHIV_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($archiv);
    }
}
