<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    { {
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

    public function generateMatricule()
    {
        $chars = '01234567abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < 50; $i++) {
            $string = $chars[rand(0, strlen($chars) - 1)];
        }
        return string;
    }
    public function create(Request $request)
    {

        $data = $request->only([
            'file',
            'adhesion_date',
            'is_finish',
            'regnum',
            'status'
        ]);

        $this->validate($data, [
            'is_finish' => 'required',
            'regnum' => 'required',
            'adhesion_date' => 'min:2',
            'status' => 'in:REJECTED,PENDING,ACCEPTED',
        ]);

        // $chars='01234567abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $string='';
        // for($i=0;$i<5;$i++){
        //    $string =$chars[rand(8,strlen($chars)-1)];
        // }

        $filePaths = $this->uploadMultipleFiles($request, 'files', 'members', ['file', 'mimes:pdf,doc,ppt,xls,rtf,jpg,png']);
        $data['files'] = json_encode($filePaths);

        $member = new Member();
        $member->regnum = $data['regnum'];
        $member->adhesion_date = $data['adhesion_date'];
        $member->status = $data['status'];
        $member->files = $data['files'];
        $member->is_finish = $data['is_finish'];


        $member->save();

        return response()->json($member);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catechesis\Membre  $membre
     * @return \Illuminate\Http\Response
     */
    public function show(Membre $membre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catechesis\Membre  $membre
     * @return \Illuminate\Http\Response
     */
    public function edit(Membre $membre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\Membre  $membre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $membre = Membre::find($id);
        if (!$membre) {
            abort(404, "No Member found with id $id");
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
        $filePaths = $this->uploadMultipleFiles($request, 'files', 'members', ['file', 'mimes:pdf,doc,ppt,xls,rtf,jpg,png']);
        $data['files'] = json_encode($filePaths);

        if (null !== $data['status']) {
            $membre->status = $data['status'];
        }
        if (null !== $data['files']) {
            $membre->files = $data['files'];
        }
        if (null !== $data['is_finish']) {
            $membre->is_finish = $data['is_finish'];
        }
        if (null !== $data['has_win']) {
            $membre->has_win = $data['has_win'];
        }
        if (null !== $data['adhesion_date']) {
            $membre->adhesion_date = $data['adhesion_date'];
        }

        $membre->update();

        return response()->json($membre);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catechesis\Membre  $membre
     * @return \Illuminate\Http\Response
     */

    public function find($id)
    {
        if (!$membre = Membre::find($id)) {
            abort(404, "No membre found with id $id");
        }
        return response()->json($membre);
    }

    public function destroy($id)
    {
        if (!$membre = Membre::find($id)) {
            abort(404, "No Membre found with id $id");
        }

        $membre->delete();
        return response()->json();
    }
}
