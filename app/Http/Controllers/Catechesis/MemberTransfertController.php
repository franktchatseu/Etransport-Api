<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\MemberTransfert;
use Illuminate\Http\Request;

class MemberTransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    { 
        {
            $data = MemberTransfert::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'member_id' => 'required:exists:members,id',
            'transfert_id' => 'required:exists:transferts,id',
        ]);

        $membertransfert = new MemberTransfert();
        $membertransfert->member_id = $data['member_id'];
        $membertransfert->transfert_id = $data['transfert_id'];
        $membertransfert->save();

        return response()->json($membertransfert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $membertransfert = MemberTransfert::find($id);
        if (!$membertransfert) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBERTRANSFERT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($membertransfert);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = MemberTransfert::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $membertransfert = MemberTransfert::find($id);
        if (!$membertransfert) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBERTRANSFERT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'member_id' => 'required:exists:members,id',
            'transfert_id' => 'required:exists:transferts,id'
        ]);

        if ( $data['member_id']) $membertransfert->member_id = $data['member_id'];
        if ( $data['transfert_id']) $membertransfert->transfert_id = $data['transfert_id'];

        $membertransfert->update();
        return response()->json($membertransfert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$membertransfert = MemberTransfert::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBERTRANSFERT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $membertransfert->delete();
        return response()->json();
    }

    public function findMemberTransferts(Request $req, $id)
    {
        $membertransfert = MemberTransfert::select('member_transferts.*', 'member_transferts.id as membertransferts_id', 'transferts.*', 'transferts.id as id_transfert')
            ->join('transferts', 'member_transferts.transfert_id', '=', 'transferts.id')
            ->where(['member_transferts.member_id' => $id])
            ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($membertransfert);
    }
}
