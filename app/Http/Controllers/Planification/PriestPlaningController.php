<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Planification\PriestPlaning;
use Illuminate\Http\Request;
use App\Models\Planification\Times;
use App\Models\person\Priest;
use App\Models\APIError;

class PriestPlaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req , $id  )
    {
        //
          $role = Priest::find($id);
        if($role == null) {
            $notFoundError = new APIError;
            $notFoundError->setStatus("404");
            $notFoundError->setCode("NOT_FOUND");
            $notFoundError->setMessage("Priest type with id " . $id . " not found");
            return response()->json($notFoundError, 404);
        } 

        $data = $req->all();
        $req->validate( [
            'user_utype_id' => 'required',
            'date' => 'required',
            'description' => 'required',
           
        ]);
        $priestplaning = new PriestPlaning();
        $priestplaning->date = $data['date'];
        $priestplaning->description = $data['description'];
        $priestplaning->user_utype_id = $data['user_utype_id'];
        /* priestplaning->place = $data['place'];
        $priestplaning->nature = $data['nature']; */

        $priestplaning->save();
        return response()->json($priestplaning);
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
     * @param  \App\Models\Planification\PriestPlaning  $priestPlaning
     * @return \Illuminate\Http\Response
     */
    public function show(PriestPlaning $priestPlaning)
    {
        //
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);
        $data = PriestPlaning::where($req->field, 'like', "%$req->q%")->get();
        return response()->json($data);
    }

    public function find($id)
    {
        if (!$priestplaning = PriestPlaning::find($id)) {
            abort(404, "No priestplaning found with id $id");
        }
        return response()->json($priestplaning);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification\PriestPlaning  $priestPlaning
     * @return \Illuminate\Http\Response
     */
    public function edit(PriestPlaning $priestPlaning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification\PriestPlaning  $priestPlaning
     * @return \Illuminate\Http\Response
     */

     public function update(Request $req , $id)
     {
        $data = $req->all();
        $data = $req->validate( [
            'date' => 'required',
            
            'description' => 'required',
        ]);
    
        $priestplaning = PriestPlaning::find($id);
        if (!$priestplaning) {
            abort(404, "No planing found with id $id");
        }
    
        if ( $data['date']) $priestplaning->date = $data['date'];
        
        if ( $data['description']) $priestplaning->description = $data['description'];
        /* if ( $data['datePro']) $priestplaning->datePro = $data['datePro'];
        if ( $data['place']) $priestplaning->place = $data['place'];
        if ( $data['nature']) $priestplaning->nature = $data['nature'];
     */
        $priestplaning->update();
        return response()->json($priestplaning);
     }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planification\PriestPlaning  $priestPlaning
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriestPlaning $priestPlaning)
    {
        //
    }
   /*  public function findPriestPlaning(Request $req, $id)
    {
        $priestPlaning = PriestPlaning::select('priest_planings.*', 'priest_planings.id as uspriestplaning_id', 'time.*', 'time.id as id_user_utype')
        ->join('user_utypes', 'priest_planings.user_utype_id', '=', 'user_utypes.id')
        ->where(['priest_planings.user_utype_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($priestPlaning);
    } */

    /* public function findPriestPlaning(Request $req, $id)
    {
        $times = Times::select('times.Start_times','times.end_times', 'times.id as times_id')
        ->join('priest_planings', 'times.id', '=', 'priest_planings.time_id')
        ->join('user_utypes', 'priest_planing.user_utype_id', '=', 'user_utype.id')
        ->join('times', 'times.isfree', '=', 'true')
        ->where(['priest_planings.user_utype_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($times);

       
    } */

      public function findPriestPlaning(Request $req, $id, $data)
    {
         $role = Priest::find($id);
        if($role == null) {
            $notFoundError = new APIError;
            $notFoundError->setStatus("404");
            $notFoundError->setCode("NOT_FOUND");
            $notFoundError->setMessage("Priest type with id " . $id . " not found");
            return response()->json($notFoundError, 404);
        } 

        $intervalle = Times::select('times.*',  'priest_planings.*', 'priest_planings.id as priest_planing_id')
        ->join('priest_planings', ['priest_planings.id' => 'times.priest_planings_id' ])
        ->where(['priest_planings.user_utype_id' => $id])
        ->where(['priest_planings.date' => $data])
        ->simplePaginate( $req->has('limit') ? $req->limit : 15);
        return response()->json($intervalle);
    } 

   /*  public function findPriest(Request $req, $data)
    {
         

        $intervalle = Times::select('times.*','users.first_name','users.last_name', 'priest_planings.*', 'priest_planings.id as priest_planing_id')
        ->join('priest_planings', ['priest_planings.id' => 'times.priest_planings_id' ])
        ->join('priests', ['priests.user_id' => 'priest_planings.user_utype_id' ])
        ->join('users', ['users.id' => 'user_utypes.id' ])
        ->where(['priest_planings.date' => $data])
        ->simplePaginate( $req->has('limit') ? $req->limit : 15);
        return response()->json($intervalle);
    }  */

    public function findPriest(Request $req, $data)
    {
         

        $intervalle = Times::select('times.*','users.first_name','users.last_name', 'priest_planings.*', 'priest_planings.id as priest_planing_id')
        ->join('priest_planings','priest_planings.id' ,'=',  'times.priest_planings_id' )
        ->join('priests', 'priests.user_utype_id' ,'=',  'priest_planings.user_utype_id' )
        ->join('user_utypes', 'user_utypes.id' ,'=',  'priest_planings.user_utype_id' )
        ->join('users', 'users.id','=', 'user_utypes.user_id' )
        ->where(['priest_planings.date' => $data])
        ->simplePaginate( $req->has('limit') ? $req->limit : 15);
        return response()->json($intervalle);
    } 
}
