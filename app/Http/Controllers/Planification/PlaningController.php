<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Planification\Planing;
use Illuminate\Http\Request;
use App\Models\APIError;

class PlaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Planing::select('planings.*','parishs.name','type_planings.name','parishs.name as parish_name','type_planings.name as type_name')
                         ->join('type_planings','type_planings.id','=','planings.type_id')
                         ->join('parishs','planings.parish_id','=','parishs.id')
                         ->simplePaginate($req->has('limit') ? $req->limit : 5);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $data = $req->except('birth_certificate');
        $this->validate($data, [
            'activity' => 'required',
            'date' => 'required',
            'description' => 'required',
            'place' => '',
            'nature' => 'required',
            'activityPro' => 'required',
            'type_id' => 'required:exists:type_planings,id',
            'parish_id' => 'required:exists:parishs,id'
        ]);

        $planing = new Planing();
        $planing->activity = $data['activity'];
        $planing->date = $data['date'];
        $planing->description = $data['description'];
        $planing->activityPro = $data['activityPro'];
        $planing->place = $data['place'];
        $planing->type_id = $data['type_id'];
        $planing->parish_id = $data['parish_id'];
        $planing->nature = $data['nature'];

        $planing->save();
        return response()->json($planing);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);
        $data = Planing::where($req->field, 'like', "%$req->q%")->get();
        return response()->json($data);
    }

    public function find(Request $req,$id)
    {
        if (!$planing =Planing::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PLANINGS_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $planings = Planing::select('planings.*','parishs.name','type_planings.name','parishs.name as         parish_name','type_planings.name as type_name')
                             ->join('type_planings',['type_planings.id'=>'planings.id'])
			     ->join('parishs','planings.parish_id','=','parishs.id')
                             ->where(['planings.id' => $id])
			     ->simplePaginate($req->has('limit') ? $req->limit : 10);
        return response()->json($planings);
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
     * @param  \App\Models\Planification\Planing  $planing
     * @return \Illuminate\Http\Response
     */
    public function show(Planing $planing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification\Planing  $planing
     * @return \Illuminate\Http\Response
     */
    public function edit(Planing $planing)
    {
        //
    }

    public function finds(Request $req,$id)
    {
        if (!$planing =Planing::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PLANINGS_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($planing);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification\Planing  $planing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $data = $req->except('birth_certificate');
        $this->validate($data, [
            'activity' => 'required',
            'date' => 'required',
            'activityPro' => 'required',
        ]);

        $planing = Planing::find($id);
        if (!$planing) {
            abort(404, "No planing found with id $id");
        }

        if ( $data['activity']) $planing->activity = $data['activity'];
        if ( $data['date']) $planing->date = $data['date'];
        if ( $data['description']) $planing->description = $data['description'];
        if ( $data['activityPro']) $planing->activityPro = $data['activityPro'];
        if ( $data['place']) $planing->place = $data['place'];
        if ( $data['type_id']) $planing->type_id = $data['type_id'];
        if ( $data['parish_id']) $planing->parish_id = $data['parish_id'];
        if ( $data['nature']) $planing->nature = $data['nature'];

        $planing->update();
        return response()->json($planing);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planifications\Planing  $planing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$planing = Planing::find($id)) {
            abort(404, "No Planing found wiht id $id");
        }
        $planing->delete();
        return response()->json();
    }

    public function findPlaningByParish(Request $req,$id,$par)
    {
        $planing= Planing::select('planings.*','parishs.name','planings.id as planing_id')
                                 ->join('user_parishs','planings.parish_id','=','user_parishs.parish_id')
                                 ->join('user_utypes','user_parishs.user_utype_id','=','user_utypes.id')
                                 ->join('users','user_utypes.user_id','=','users.id')
                                 ->join('parishs','user_parishs.parish_id','=','parishs.id')
                                 ->where(['users.id' => $id])
                                 ->where(['user_parishs.parish_id' => $par])
                                 ->simplePaginate($req->has('limit') ? $req->limit : 10);

        return response()->json($planing);
    }
}
