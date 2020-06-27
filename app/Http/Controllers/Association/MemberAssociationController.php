<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use App\Models\Association\MemberAssociation;
use Illuminate\Http\Request;
use App\Models\APIError;

class MemberAssociationController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = MemberAssociation::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'date_adhesion' => 'required',
            'status' => 'in:PENDING,REJECTED,ACCEPTED',
            'user_id' => 'required',
            'statut_id' => 'required',
            'association_id' => 'required'
        ]);

            $memberAssociation = new MemberAssociation();
            $memberAssociation->date_adhesion = $data['date_adhesion'];
            $memberAssociation->status = $data['status'];
            $memberAssociation->user_id = $data['user_id'];
            $memberAssociation->statut_id = $data['statut_id'];
            $memberAssociation->association_id = $data['association_id'];
            $memberAssociation->save();
       
        return response()->json($memberAssociation);
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
        $memberAssociation = MemberAssociation::find($id);
        if (!$memberAssociation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBERASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'date_adhesion' => 'required',
            'status' => 'in:PENDING,REJECTED,ACCEPTED',
            'user_id' => 'required',
            'statut_id' => 'required',
            'association_id' => 'required'

        ]);

        if (null !== $data['date_adhesion']) $memberAssociation->date_adhesion = $data['date_adhesion'];
        if (null !== $data['status']) $memberAssociation->status = $data['status'];
        if (null !== $data['user_id']) $memberAssociation->user_id = $data['user_id'];
        if (null !== $data['statut_id']) $memberAssociation->status_id = $data['statut_id'];
        if (null !== $data['association_id']) $memberAssociation->association_id = $data['association_id'];

        $memberAssociation->update();

        return response()->json($memberAssociation);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $memberAssociation = MemberAssociation::find($id);
        if (!$memberAssociation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBERASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $memberAssociation->delete();      
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

        $data = MemberAssociation::where($req->field, 'like', "%$req->q%")
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
        $memberAssociation = MemberAssociation::find($id);
        if (!$memberAssociation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBERASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($memberAssociation);
    }

    public function findMemberAssociation(Request $req, $id)
    {
        $memberAssociation = MemberAssociation::select('member_associations.id','member_associations.status','member_associations.date_adhesion','users.first_name','users.last_name','associations.name','associations.slogan','statuts.name_post')
        ->join('associations', 'member_associations.association_id', '=', 'associations.id' )
        ->join('users', 'member_associations.user_id', '=', 'users.id' )
        ->join('statuts', 'member_associations.statut_id', '=', 'statuts.id' )
        ->where(['member_associations.user_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($memberAssociation);
    }
}
