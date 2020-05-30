<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Association\Status;

class StatusController extends Controller
{
     //
     public function store(Request $req){
        $data = $req->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'name' => 'required'
        ]);

        
        $status = new Status();
        $status->name = $data['name'];
        $status->description = $data['description'];
        $status->save();
       
        return response()->json($status);
    }


    public function update(Request $req, $id)
    {
        $status = Status::find($id);
        if (!$status) {
            abort(404, "No status$status found with id $id");
        }

        $data = $req->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'name' => 'required'
        ]);

        if (null !== $data['name']) $status->name = $data['name'];
        if (null !== $data['description']) $status->description = $data['description'];
       
        $status->update();
        return response()->json($status);
    }


    public function destroy($id)
    {
        if (!$status = Status::find($id)) {
            abort(404, "No status$status found with id $id");
        }

        $status->delete();      
        return response()->json();
    }


    public function find($id)
    {
        if (!$status = Status::find($id)) {
            abort(404, "No status$status found with id $id");
        }
        return response()->json($status);
    }

    public function index(Request $req)
    {
        $data = Status::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',// on cherche q dans la table sur le champ field
            'field' => 'present'
        ]);

        $data = Status::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    }
}
