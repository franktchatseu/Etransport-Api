<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\AnnualmemberAuthorization;
use Illuminate\Http\Request;

class AnnualmemberAuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    { 
        {
            $data = AnnualmemberAuthorization::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->except('photo');

        $this->validate($data, [
            'annualannualmember_id' => 'required:exists:annual_members,id',
            'authorization_id' => 'required:exists:authorizations,id',
            'date' => 'required',
            'status' => 'in:PENDING,REJECTED,ACCEPTED',
        ]);

        $annualmemberAuthorization = new AnnualmemberAuthorization();
        $annualmemberAuthorization->annualannualmember_id = $data['annualannualmember_id'];
        $annualmemberAuthorization->authorization_id = $data['authorization_id'];
        $annualmemberAuthorization->date = $data['date'];
        $annualmemberAuthorization->status = $data['status'];
        $annualmemberAuthorization->save();

        return response()->json($annualmemberAuthorization);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catechesis\AnnualmemberAuthorization  $annualmemberAuthorization
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $annualmemberAuthorization = AnnualmemberAuthorization::find($id);
        if (!$annualmemberAuthorization) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ANNUALMEMBERAUTHORIZATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($annualmemberAuthorization);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);
        $data = AnnualmemberAuthorization::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\AnnualmemberAuthorization  $annualmemberAuthorization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $annualmemberAuthorization = AnnualmemberAuthorization::find($id);
        if (!$annualmemberAuthorization) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ANNUALMEMBERAUTHORIZATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'annualannualmember_id' => 'required:exists:annual_members,id',
            'authorization_id' => 'required:exists:authorizations,id',
            'date' => 'required',
            'status' => 'in:PENDING,REJECTED,ACCEPTED',
        ]);

        if (null !== $data['annualmember_id']) $annualmemberAuthorization->annualmember_id = $data['annualmember_id'];
        if (null !== $data['authorization_id']) $annualmemberAuthorization->authorization_id = $data['authorization_id'];
        if (null !== $data['date']) {
            $annualmemberAuthorization->date = $data['date'];
        } 
        if (null !== $data['status']) {
            $annualmemberAuthorization->status = $data['status'];
        }

        $annualmemberAuthorization->update();
        return response()->json($annualmemberAuthorization);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catechesis\AnnualmemberAuthorization  $annualmemberAuthorization
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$annualmemberAuthorization = AnnualmemberAuthorization::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ANNUALMEMBERAUTHORIZATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $annualmemberAuthorization->delete();
        return response()->json();
    }

    public function findAnnualmemberAuthorization(Request $req, $id)
    {
        $annualmemberAuthorization = AnnualmemberAuthorization::select('annualmember_authorizations.*', 'annualmember_authorizations.id as annualmemberAuthorizations_id', 'authorizations.*', 'authorizations.id as id_authorization')
            ->join('authorizations', 'annualmember_authorizations.authorization_id', '=', 'authorizations.id')
            ->where(['annualmember_authorizations.annualmember_id' => $id])
            ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($annualmemberAuthorization);
    }
}
