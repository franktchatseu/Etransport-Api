<?php

namespace App\Http\Controllers\Sanction;

use App\Http\Controllers\Controller;
use App\Models\APIError;
use App\Models\Sanction\UserSanction;
use Illuminate\Http\Request;

class UserSanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = UserSanction::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'reason' => 'required',
            'user_id' => 'required:exists:users,id',
            'sanction_id' => 'required:exists:sanctions,id'
         ]);


            $usersanction = new UserSanction();
            $usersanction->reason = $data['reason'];
            $usersanction->user_id = $data['user_id'];
            $usersanction->sanction_id = $data['sanction_id'];
            $usersanction->save();
       
        return response()->json($usersanction);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sanction\UserSanction  $userSanction
     * @return \Illuminate\Http\Response
     */
    public function show(UserSanction $userSanction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sanction\UserSanction  $userSanction
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSanction $userSanction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sanction\UserSanction  $userSanction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $usersanction = UserSanction::find($id);
        if (!$usersanction) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USERSANCTION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'reason' => 'required',
            'user_id' => 'required:exists:users,id',
            'sanction_id' => 'required:exists:sanctions,id'
         ]);

        
        if (null !== $data['reason']) $usersanction->reason = $data['reason'];
        if (null !== $data['user_id']) $usersanction->user_id = $data['user_id'];
        if (null !== $data['sanction_id']) $usersanction->sanction_id = $data['sanction_id'];

        $usersanction->update();
        return response()->json($usersanction);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sanction\UserSanction  $userSanction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$usersanction = UserSanction::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USERSANCTION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $usersanction->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = UserSanction::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$sanction = UserSanction::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USERSANCTION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($sanction);
    }

    public function findUserSanctions(Request $req, $id)
    {
        $sanctions = UserSanction::select('user_sanctions.*', 'user_sanctions.id as usanction_id', 'sanctions.*', 'sanctions.id as id_sanction')
        ->join('sanctions', 'user_sanctions.sanction_id', '=', 'sanctions.id')
        ->where(['user_sanctions.user_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($sanctions);
    }
}
