<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use App\Models\Association\Statut;
use Illuminate\Http\Request;
use App\Models\APIError;

class StatusController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Statut::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'name_post' => 'required',
            'role_post' => 'required'
        ]);

            $statut = new Statut();
            $statut->name_post = $data['name_post'];
            $statut->role_post = $data['role_post'];
            $statut->save();
       
        return response()->json($statut);
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
        $statut = Statut::find($id);
        if (!$statut) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("STATUT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name_post' => 'required',
            'role_post' => 'required'
        ]);

        if (null !== $data['name_post']) $statut->name_post = $data['name_post'];
        if (null !== $data['role_post']) $statut->role_post = $data['role_post'];

        $statut->update();

        return response()->json($statut);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $statut = Statut::find($id);
        if (!$statut) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("STATUT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $statut->delete();      
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

        $data = Statut::where($req->field, 'like', "%$req->q%")
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
        $statut = Statut::find($id);
        if (!$statut) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("STATUT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($statut);
    }
/* 
    public function findAnnuelMembers(Request $req, $id)
    {
        $statut = Statut::find($id);
        if (!$statut) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Statut_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $statuts = AnnualMember::whereStatutId($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($statuts);
    }  */

}
