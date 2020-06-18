<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Association\TypeAssociation;

class TypeAssociationController extends Controller
{
    public function index (Request $req)
    {
        $data = TypeAssociation::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'description' => 'required'
        ]);

        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description']));
            
        $assoc = TypeAssociation::create($data);
        return response()->json($assoc);
    }

    public function show($id)
    {
        $assoc = TypeAssociation::find($id);
        if ($assoc == null)
            return response()->json('not found', 404);
        return response()->json($assoc);
    }

    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        $assoc = TypeAssociation::find($id);
        if (!$assoc) {
            return response()->json(404, "No type association found with id $id");
        }
        
        $this->validate($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);

        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description']));
            
        $assoc = TypeAssociation::create($data);
        return response()->json($assoc);
    }

    public function destroy($id)
    {
        if (!$assoc = TypeAssociation::find($id)) {
            return response()->json(404, "No type association found with id $id");
        }

        $assoc->delete();      
        return response()->json('deleted');
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = TypeAssociation::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$assoc = TypeAssociation::find($id)) {
            return response()->json(404, "No type association found with id $id");
        }
        return response()->json($assoc);
    }
}
