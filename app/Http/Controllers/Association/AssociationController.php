<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Association\Association;
use App\Models\Association\TypeAssociation;
use App\Models\Association\MemberAssociation;
use App\Models\APIError;
 use DB;
class AssociationController extends Controller
{
    public function index (Request $req)
    {
      
        $data = Association::implePaginate($req->has('limit') ? $req->limit : 15);
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
    //detail des membres associations avec les membres dubur
    public function findWithMemberBureau($id)
    {
        $assoc = Association::find($id);
        if (!$assoc) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $memberAssociation = MemberAssociation::select('member_associations.association_id as association_id','users.first_name','users.last_name','users.avatar','statuts.name_post')
        
        ->join('associations', 'member_associations.association_id', '=', 'associations.id' )
        ->join('user_utypes', 'member_associations.user_utype_id', '=', 'user_utypes.id' )
        ->join('users', 'user_utypes.user_id', '=', 'users.id' )
        ->join('statuts', 'member_associations.statut_id', '=', 'statuts.id' )
        ->where(['member_associations.association_id' => $id])
       // ->where('statuts.name_post','!=','member')
        ->get();

        return response()->json([
                'association_id' =>  $assoc->id,
                'name' =>  $assoc->name,
                'slogan' =>   $assoc->logo,
                'description' =>   $assoc->description,
                'reglement' => $assoc->reglement,
                'memberofbureau' => $memberAssociation
            
        ]);
    }


    public function findTypeAssociation(Request $req, $id)
    {
        $parishAssociation = Association::select('associations.id','associations.name as association_name','associations.photo as photo ','type_associations.name as name_type_association','associations.slogan','users.first_name','users.last_name','parishs.name as name_parish')
        ->join('parishs', 'associations.parish_id', '=', 'parishs.id' )
        ->join('type_associations', 'associations.type_id', '=', 'type_associations.id' )
        ->join('users', 'associations.user_id', '=', 'users.id' )
        ->where(['associations.type_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($parishAssociation);
    }

    //recuperation des associations d'une paroisse donnee
    public function findParishAssociation(Request $req, $id)
    {
        $parishAssociations =  DB::table('associations')
        ->select('associations.id','associations.name','associations.lieu','associations.slogan', 'associations.photo as photo', 'users.first_name as responsable_first_name','users.tel as responsable_tel','users.last_name as responsable_last_name','associations.rencontre','type_associations.name as type_association_name')
        ->join('parishs', 'parishs.id', '=', 'associations.user_id' )
        ->join('users', 'users.id', '=', 'associations.parish_id' )
        ->join('type_associations', 'type_associations.id', '=', 'associations.type_id' )
        ->where(['associations.parish_id' => $id])
        ->get()
        ->groupBy('type_association_name');;
        foreach ($parishAssociations as $parishAssociation) {
            foreach ($parishAssociation as $item) {
                //dd($item);
                $item->photo =  url($item->photo);
                //$parishAssociation->photo =  url($parishAssociation->photo);
             }
            //$parishAssociation->photo =  url($parishAssociation->photo);
        }
        return response()->json($parishAssociations);
    }



    
}
