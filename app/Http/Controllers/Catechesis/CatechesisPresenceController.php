<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\CatechesisPresence;
use Illuminate\Http\Request;

class CatechesisPresenceController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = CatechesisPresence::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'user_catechesis_id' => 'required',
           
        ]);

            $catechesisPresence = new CatechesisPresence();
            $catechesisPresence->plug_id = $data['plug_id'];
            $catechesisPresence->user_catechesis_id = $data['user_catechesis_id'];
            $catechesisPresence->save();
       
        return response()->json($catechesisPresence);
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
        $catechesisPresence = CatechesisPresence::find($id);
        if (!$catechesisPresence) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CatechesisPresence_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'plug_id' => 'required',
            'user_catechesis_id' => 'required'
           
        ]);

        if (null !== $data['plug_id']) $catechesisPresence->plug_id = $data['plug_id'];
        if (null !== $data['user_catechesis_id']) $catechesisPresence->user_catechesis_id = $data['user_catechesis_id'];
        $catechesisPresence->update();

        return response()->json($catechesisPresence);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $catechesisPresence = CatechesisPresence::find($id);
        if (!$catechesisPresence) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CatechesisPresence_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $catechesisPresence->delete();      
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

        $data = CatechesisPresence::where($req->field, 'like', "%$req->q%")
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
        $catechesisPresence = CatechesisPresence::find($id);
        if (!$catechesisPresence) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CatechesisPresence_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($catechesisPresence);
    }

    public function findCatechesisPresences(Request $req, $id)
    {/* 
        $CatechesisPresence = CatechesisPresence::select('catechesis_presences.*', 'catechesis_presences.id as ucathedral_presence_id', 'plugs.*', 'plugs.id as id_plug', 'catechesis.*', 'catechesis.id as id_catechesis')
        ->join('catechesis', 'catechesis_presences.catechesis_presences_id', '=', 'catechesis.id', '&&', 'plugs', 'catechesis_presences.catechesis_presences_id', '=', 'plugs.id' ) */

        $catechesisPresence = CatechesisPresence::select('catechesis_presences.*','catechesis_presences.id as catechesis_presence_id', 'plugs.*', 'plugs.id as id_plug')
        ->join('plugs', 'catechesis_presences.plug_id', '=', 'plugs.id' )
        ->where(['catechesis_presences.user_catechesis_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($catechesisPresence);
    }
}
