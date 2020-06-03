<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Planification\UserPlanning;
use Illuminate\Http\Request;

class UserPlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = UserPlanning::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'planing_id' => 'required:exists:planings,id'           
         ]);


            $userPlanning = new UserPlanning();
            $userPlanning->user_id = $data['user_id'];
            $userPlanning->planing_id = $data['planing_id'];
            $userPlanning->save();
       
        return response()->json($userPlanning);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planification\UserPlanning  $userPlanning
     * @return \Illuminate\Http\Response
     */
    public function show(UserPlanning $userPlanning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification\UserPlanning  $userPlanning
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPlanning $userPlanning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification\UserPlanning  $userPlanning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $userPlanning = UserPlanning::find($id);
        if (!$userPlanning) {
            abort(404, "No userPlanning found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
           'user_id' => 'required:exists:users,id',
            'planing_id' => 'required:exists:planings,id'
         ]);

        
        if (null !== $data['user_id']) $userPlanning->user_id = $data['user_id'];
        if (null !== $data['planing_id']) $userPlanning->planing_id = $data['planing_id'];

        
        $userPlanning->update();

        return response()->json($userPlanning);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planification\UserPlanning  $userPlanning
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$userPlanning = UserPlanning::find($id)) {
            abort(404, "No userPlanning found with id $id");
        }

        $userPlanning->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = UserPlanning::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$userPlanning = UserPlanning::find($id)) {
            abort(404, "No userPlanning found with id $id");
        }
        return response()->json($userPlanning);
    }

    public function findAssociationPlaning(Request $req, $id)
    {
        $planing = UserPlanning::select('user_planings.*', 'user_planings.id as uplaning_id', 'planings.*', 'planings.id as id_planing')
        ->join('planings', 'user_planings.planing_id', '=', 'planings.id')
        ->where(['user_planings.user_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($planing);
    }
}
