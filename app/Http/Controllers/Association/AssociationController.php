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
            'type_id' => 'required',
            'parish_id' => 'required',
            'user_id' => 'required',
        ]);
        $data = [];
        if ($request->has('reglement')) {
            $filePaths = $this->saveMultipleImages($this, $request, 'reglement', 'archivings');
            $data['reglement'] = json_encode(['images' => $filePaths]);
        }

        $data = array_merge($data, $request->only([
            'name', 
            'type_id',
            'parish_id',
            'user_id', 
            'slogan', 
            'description', 
            'dateCreation'
        ]));
        $assoc = Association::create($data);
        $assoc->reglement = json_decode($assoc->reglement);
        return response()->json($assoc);
    }


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
            'type_id' => 'required',
            'parish_id' => 'required',
            'user_id' => 'required',
        ]);
        $data = [];
        if ($request->has('reglement')) {
            $filePaths = $this->saveMultipleImages($this, $request, 'reglement', 'archivings');
            $data['reglement'] = json_encode(['images' => $filePaths]);
        }

        $data = array_merge($data, $request->only([
            'name', 
            'type_id',
            'parish_id',
            'user_id', 
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

    public function findTypeAssociation(Request $req, $id)
    {
        $parishAssociation = Association::select('associations.id','associations.name as association_name','type_associations.name as name_type_association','associations.slogan','users.first_name','users.last_name','parishs.name as name_parish')
        ->join('parishs', 'associations.parish_id', '=', 'parishs.id' )
        ->join('type_associations', 'associations.type_id', '=', 'type_associations.id' )
        ->join('users', 'associations.user_id', '=', 'users.id' )
        ->where(['associations.type_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($parishAssociation);
    }

    
}
