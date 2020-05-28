<?php

namespace App\Http\Controllers\Sanction;

use App\Http\Controllers\Controller;
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
            abort(404, "No user$usersanction found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'reason' => 'required',
            'user_id' => 'required:exists:users,id',
            'sanction_id' => 'required:exists:sanctions,id'
         ]);

        
        if (null !== $data['reason']) $usersanction->reason = $data['reason'];
        if (null !== $data['user_id']) $usersanction->user_id = $data['user_id'];
        if (null !== $data['type_id']) $usersanction->type_id = $data['type_id'];

        
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
            abort(404, "No user found with id $id");
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
            abort(404, "No user found with id $id");
        }
        return response()->json($sanction);
    }
}
