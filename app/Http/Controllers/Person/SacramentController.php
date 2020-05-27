<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Person\Sacrament;
use Illuminate\Http\Request;

class SacramentController extends Controller
{
    //
    public function createStatement(Request $req){
        $data = $req->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'name' => 'required'
        ]);

        
        $sacrament = new Sacrament();
        $sacrament->name = $data['name'];
        $sacrament->description = $data['description'];
        $sacrament->save();
       
        return response()->json($sacrament);
    }


    public function updateStatement(Request $req, $id)
    {
        $sacrament = Sacrament::find($id);
        if (!$sacrament) {
            abort(404, "No sacrament found with id $id");
        }

        $data = $req->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'name' => 'required'
        ]);

        if (null !== $data['name']) $sacrament->name = $data['name'];
        if (null !== $data['description']) $sacrament->description = $data['description'];
       
        $sacrament->update();
        return response()->json($sacrament);
    }


    public function destroyStatement($id)
    {
        if (!$sacrament = Sacrament::find($id)) {
            abort(404, "No sacrament found with id $id");
        }

        $sacrament->delete();      
        return response()->json();
    }


    public function findStatement($id)
    {
        if (!$sacrament = Sacrament::find($id)) {
            abort(404, "No sacrament found with id $id");
        }
        return response()->json($sacrament);
    }

    public function allSacrament(Request $req){
        $data = Sacrament::simplePaginate($req->has('limit')?$req->limit:15);
        return response()->json($data);
    }

    public function searchStatement(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',// on cherche q dans la table sur le champ field
            'field' => 'present'
        ]);

        $data = Sacrament::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    }
}
