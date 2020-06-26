<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\UserParish;
use Illuminate\Http\Request;

class UserParishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = UserParish::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'user_utype_id' => 'required:exists:user_utypes,id',
            'parish_id' => 'required:exists:parishs,id'
            
         ]);


            $userParish = new UserParish();
            $userParish->user_utype_id = $data['user_utype_id'];
            $userParish->parish_id = $data['parish_id'];
            $userParish->save();
       
        return response()->json($userParish);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting\UserParish  $userParish
     * @return \Illuminate\Http\Response
     */
    public function show(UserParish $userParish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting\UserParish  $userParish
     * @return \Illuminate\Http\Response
     */
    public function edit(UserParish $userParish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting\UserParish  $userParish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $userParish = UserParish::find($id);
        if (!$userParish) {
            abort(404, "No userParish found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'user_utype_id' => 'required:exists:user_utypes,id',
            'parish_id' => 'required:exists:parishs,id'
            
         ]);

        
         if ( $data['user_utype_id']) $userParish->user_utype_id = $data['user_utype_id'];
         if ( $data['parish_id']) $userParish->parish_id = $data['parish_id'];

        
        $userParish->update();

        return response()->json($userParish);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting\UserParish  $userParish
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$userParish = UserParish::find($id)) {
            abort(404, "No user found with id $id");
        }

        $userParish->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = UserParish::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$userParish = UserParish::find($id)) {
            abort(404, "No user Parish found with id $id");
        }
        return response()->json($userParish);
    }

    public function findUserParish(Request $req, $id)
    {
        $parish = UserParish::select('user_parishs.*', 'user_parishs.id as uparish_id', 'parishs.*', 'parishs.id as id_parish')
        ->join('parishs', 'user_parishs.parish_id', '=', 'parishs.id')
        ->where(['user_parishs.user_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($parish);
    }
}
