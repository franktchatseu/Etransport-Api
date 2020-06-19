<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Association\Association;
use App\Models\Association\TypeAssociation;

class AssociationController extends Controller
{
    public function index (Request $req)
    {
        $data = Association::simplePaginate($req->has('limit') ? $req->limit : 15);
        foreach($data as $assoc){
            $type = TypeAssociation::whereId($assoc->typeId)->first();
            $assoc['type'] = $type;
        }
        return response()->json($data);
    }
    

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
        $this->validate($request->all(), [
            'name' => 'required',
            'type_id' => 'required'
        ]);
        $data = [];
        if ($request->has('reglement')) {
            $filePaths = $this->saveMultipleImages($this, $request, 'reglement', 'archivings');
            $data['reglement'] = json_encode(['images' => $filePaths]);
        }

        $data = array_merge($data, $request->only([
            'name', 
            'type_id', 
            'slogan', 
            'description', 
            'dateCreation']));
        $assoc = Association::create($data);
        $assoc->reglement = json_decode($assoc->reglement);
        return response()->json($assoc);
    }


        /* 
        $this->validate($request->all(), [
            'name' => 'required',
            'type_id' => 'required'
        ]);

        $data = [];
        if ($request->has('reglement')) {
            $filePaths = $this->uploadMultipleFiles($request, 'reglement', 'archivings',['file','mimes:pdf,doc,ppt,xls,rtf']);
            $data['reglement'] = json_encode([$filePaths]);
        }
        $data = array_merge($data, $request->only([
            'name', 
            'type_id', 
            'slogan', 
            'description', 
            'dateCreation']));
            
        $assoc = Association::create($data);
        $assoc->reglement = json_decode($assoc->reglement);
        return response()->json($assoc); */
//    }

/*     public function store(Request $request)
    {
        $data = $request->except('');

        $this->validate($data, [
            'name' => 'required',
            'type_id' => 'required',
            'slogan' => '',
            'description' => '',
            'dateCreation' => ''
        ]);

      
        $data['reglement'] = '';
        //upload image
        if ($file = $request->file('file')) {
            $filePaths = $this->saveMultipleImages($this, $request, 'reglement', 'association');
            $data['file'] = json_encode(['file' => $filePaths]);
        }

       /*  if(isset($request->file)){
            $file = $request->file('file');
            $path = null;
            if($file != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/associations";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
            }
            $data['file'] = $path;

        } */
/* 
        $associ = new Association();
        $associ->name = $data['name'];
        $associ->type_id = $data['type_id'];
        $associ->slogan = $data['slogan'];
        $associ->description = $data['description'];
        $associ->dateCreation = $data['dateCreation'];
        $associ->reglement = $data['file'];
        $associ->save();
              
        return response()->json($associ);
    }  */


    public function show($id)
    {
        $assoc = Association::find($id);
        if (!$assoc) 
        {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $type = TypeAssociation::whereId($assoc->typeId);
        $assoc['type_id'] = $type;

        return response()->json($assoc);
    }

    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        $assoc = Association::find($id);
        if (!$assoc) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $this->validate($request->all(), [
            'name' => 'required',
            'type_id' => 'required'
        ]);
        $data = [];
        if ($request->has('reglement')) {
            $filePaths = $this->saveMultipleImages($this, $request, 'reglement', 'archivings');
            $data['reglement'] = json_encode(['images' => $filePaths]);
        }

        $data = array_merge($data, $request->only([
            'name', 
            'type_id', 
            'slogan', 
            'description', 
            'dateCreation']));
        $assoc = Association::create($data);
        $assoc->reglement = json_decode($assoc->reglement);
        return response()->json($assoc);
    }

    public function destroy($id)
    {
        if (!$assoc = Association::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $assoc->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Association::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    public function find($id)
    {
        if (!$assoc = Association::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($assoc);
    }
}
