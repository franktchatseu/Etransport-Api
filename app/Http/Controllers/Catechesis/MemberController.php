<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Member;
use Illuminate\Http\Request;
use App\Models\APIError;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    { 
        {
            $data = Member::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Member::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function create(Request $request)
    {

        $data = $request->only([
            'file',
            'adhesion_date',
            'is_finish',
            'has_win',
            'regnum',
            'status'
        ]);

        $this->validate($data, [
            'is_finish' => 'required',
            'has_win' => 'required',
            'regnum' => 'required',
            'adhesion_date' => 'min:2',
            'status' => 'in:REJECTED,PENDING,ACCEPTED',
        ]);

        // $chars='01234567abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $string='';
        // for($i=0;$i<5;$i++){
        //    $string =$chars[rand(8,strlen($chars)-1)];
        // }

        // $filePaths = $this->uploadMultipleFiles($request, 'files', 'members', ['file', 'mimes:pdf,doc,ppt,xls,rtf,jpg,png']);
        if ($request->file('files') !== null) {
            $filePaths = $this->saveMultipleImages($this, $request, 'files', 'members');
            $data['files'] = json_encode(['images' => $filePaths]);
        }

        $member = new Member();
        $member->regnum = $data['regnum'];
        $member->adhesion_date = $data['adhesion_date'];
        $member->status = $data['status'];
        $member->files = $data['files'];
        $member->has_win = $data['has_win'];
        $member->is_finish = $data['is_finish'];


        $member->save();

        return response()->json($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $member = Member::find($id);
        if (!$member) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
        }


        $data = $request->only([
            'file',
            'adhesion_date',
            'is_finish',
            'status'
        ]);

        $this->validate($data, [
            'is_finish' => 'required',
            'has_win' => 'required',
            'adhesion_date' => 'required',
            'status' => 'in:Rejected,Painding,Accepted',
        ]);

        //upload image
        $filePaths = $this->saveMultipleImages($this, $request, 'files', 'members');
        $data['files'] = json_encode(['images' => $filePaths]);

        if ( $data['status'] ?? null) {
            $member->status = $data['status'];
        }
        if ( $data['files'] ?? null) {
            $member->files = $data['files'];
        }
        if ( $data['is_finish'] ?? null) {
            $member->is_finish = $data['is_finish'];
        }
        if ( $data['has_win'] ?? null) {
            $member->has_win = $data['has_win'];
        }
        if ( $data['adhesion_date'] ?? null) {
            $member->adhesion_date = $data['adhesion_date'];
        }

        $member->update();

        return response()->json($member);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catechesis\Member  $member
     * @return \Illuminate\Http\Response
     */

    public function find($id)
    {
        $member = Member::find($id);
        if (!$member) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($member);
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        if (!$member) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $member->delete();
        return response()->json();
    }
}
