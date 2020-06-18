<?php

namespace App\Http\Controllers\Sacrament;

use App\Http\Controllers\Controller;
use App\Models\Sacrament\UserSacrament;
use Illuminate\Http\Request;

class UserSacramentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = UserSacrament::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'user_id' => 'required:exists:users,id',
            'sacrament_id' => 'required:exists:sacraments,id',
            'request' => '',
            'isAspire' => 'required'
         ]);


            $userSacrament = new UserSacrament();
            $userSacrament->request = $data['request'];
            $userSacrament->isAspire = $data['isAspire'];
            $userSacrament->user_id = $data['user_id'];
            $userSacrament->sacrament_id = $data['sacrament_id'];
            $userSacrament->save();
       
        return response()->json($userSacrament);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sacrament\UserSacrament  $userSacrament
     * @return \Illuminate\Http\Response
     */
    public function show(UserSacrament $userSacrament)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sacrament\UserSacrament  $userSacrament
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSacrament $userSacrament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sacrament\UserSacrament  $userSacrament
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $userSacrament = UserSacrament::find($id);
        if (!$userSacrament) {
            abort(404, "No userSacrament found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'request' => '',
            'isAspire' => 'required',
            'user_id' => 'required:exists:users,id',
            'sacrament_id' => 'required:exists:sacraments,id'
         ]);

        
         if ( $data['request']) $userSacrament->request = $data['request'];
         if ( $data['isAspire']) $userSacrament->isAspire = $data['isAspire'];
         if ( $data['user_id']) $userSacrament->user_id = $data['user_id'];
        if ( $data['sacrament_id']) $userSacrament->sacrament_id = $data['sacrament_id'];

        
        $userSacrament->update();

        return response()->json($userSacrament);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sacrament\UserSacrament  $userSacrament
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$userSacrament = UserSacrament::find($id)) {
            abort(404, "No user found with id $id");
        }

        $userSacrament->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = UserSacrament::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$userSacrament = UserSacrament::find($id)) {
            abort(404, "No usersacrament found with id $id");
        }
        return response()->json($userSacrament);
    }

    public function findUserSacrament(Request $req, $id)
    {
        $sacrament = UserSacrament::select('user_sacraments.*', 'user_sacraments.id as usacrament_id', 'sacraments.*', 'sacraments.id as id_sacrament')
        ->join('sacraments', 'user_sacraments.sacrament_id', '=', 'sacraments.id')
        ->where(['user_sacraments.user_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($sacrament);
    }
}
