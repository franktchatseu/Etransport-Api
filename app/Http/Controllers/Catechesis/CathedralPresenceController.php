<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\CathedralPresence;
use Illuminate\Http\Request;

class CathedralPresenceController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = CathedralPresence::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'plug_id' => 'required',
            'cathechesis_id' => 'required',
            'annual_member_id' => 'required',
            'date_days' => ''
        ]);

            $cathedralPresence = new CathedralPresence();
            $cathedralPresence->plug_id = $data['plug_id'];
            $cathedralPresence->cathechesis_id = $data['cathechesis_id'];
            $cathedralPresence->annual_member_id = $data['annual_member_id'];
            $cathedralPresence->date_days = $data['date_days'];
            $cathedralPresence->save();
       
        return response()->json($cathedralPresence);
    }

   /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $cathedralPresence = CathedralPresence::find($id);
        if (!$cathedralPresence) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATHEDRALPRESENCE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'plug_id' => 'required',
            'cathechesis_id' => 'required',
            'annual_member_id' => 'required',
            'date_days' => ''
        ]);

        if (null !== $data['plug_id']) $cathedralPresence->plug_id = $data['plug_id'];
        if (null !== $data['cathechesis_id']) $cathedralPresence->cathechesis_id = $data['cathechesis_id'];
        if (null !== $data['annual_member_id']) $cathedralPresence->annual_member_id = $data['annual_member_id'];
        if (null !== $data['date_days']) $cathedralPresence->date_days = $data['date_days'];

        $cathedralPresence->update();

        return response()->json($cathedralPresence);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cathedralPresence = CathedralPresence::find($id);
        if (!$cathedralPresence) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATHEDRALPRESENCE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $cathedralPresence->delete();      
        return response()->json();
    }
/**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = CathedralPresence::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $cathedralPresence = CathedralPresence::find($id);
        if (!$cathedralPresence) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATHEDRALPRESENCE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($cathedralPresence);
    }

    public function findCathedralPesences(Request $req, $id)
    {/* 
        $cathedralPresence = CathedralPresence::select('cathedral_presences.*', 'cathedral_presences.id as ucathedral_presence_id', 'plugs.*', 'plugs.id as id_plug', 'catechesis.*', 'catechesis.id as id_catechesis')
        ->join('catechesis', 'cathedral_presences.cathedral_presences_id', '=', 'catechesis.id', '&&', 'plugs', 'cathedral_presences.cathedral_presences_id', '=', 'plugs.id' ) */

        $cathedralPresence = CathedralPresence::select('cathedral_presences.*','cathedral_presences.id as cathedral_presence_id', 'catechesis.*', 'catechesis.id as id_catechesis','catechesis.name as name_catechesis', 'plugs.*')
        ->join('plugs', 'cathedral_presences.plug_id', '=', 'plugs.id' )
        ->join('catechesis', 'cathedral_presences.cathechesis_id', '=', 'catechesis.id' )
        ->where(['cathedral_presences.annual_member_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($cathedralPresence);
    }
}
