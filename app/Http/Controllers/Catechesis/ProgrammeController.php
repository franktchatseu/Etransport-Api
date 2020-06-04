<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Programme;
use Illuminate\Http\Request;
use App\Models\APIError;

class ProgrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     *by tchamou:tchamou tchamouramses@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        {
            $data = Programme::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    public function get(Request $req)
    {
     
    }


    /**
     * Show the form for creating a new resource.
     **by tchamou:tchamou tchamouramses@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        
        $request->validate([
            'duree' => 'required',
            'heure_debut' => 'required',
            'jour' => 'required|in:LUNDI,MARDI,MERCREDI,JEUDI,VENDREDI,SAMEDI,DIMANCHE',
            'date_planifiee' => 'required',
            'type' => 'required|in:REGULIER,IRREGULIER'
        ]);

        $programme = new Programme();
        $programme::create([
            'duree' => $request->duree,
            'jour' => $request->jour,
            'heure_debut' => $request->heure_debut,
            'date_planifiee' => $request->date_planifiee,
            'type' => $request->type
        ]);
        
        return response()->json($programme);
    }

    /**
     * Store a newly created resource in storage.
     **by tchamou:tchamou tchamouramses@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     **by tchamou:tchamou tchamouramses@gmail.com
     * @param  \App\Models\Catechesis\Programme  $AnnualMember
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     **by tchamou:tchamou tchamouramses@gmail.com
     * @param  \App\Models\Catechesis\Programme  $AnnualMember
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     **by tchamou:tchamou tchamouramses@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\Programme  $AnnualMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        
        $request->validate([
            'duree' => 'required',
            'heure_debut' => 'required',
            'jour' => 'required',
            'date_planifiee' => 'required',
            'type' => 'required'
        ]);

        $programme = Programme::find($id);
        if($programme == null){
            abort(404, "No Programme found with id $id");
        }
        $programme->duree = $request->duree;
        $programme->jour = $request->jour;
        $programme->date_planifiee = $request->date_planifiee;
        $programme->heure_debut = $request->heure_debut;
        $programme->type = $request->type;

        $programme->update();
        return response()->json($programme);
    }


    /**
     * Remove the specified resource from storage.
     **by tchamou:tchamou tchamouramses@gmail.com
     * @param  \App\Models\Catechesis\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
            if (!$programme = Programme::find($id)) {
                abort(404, "No AnnualMember found with id $id");
            }
            return response()->json($programme);
    }
    
    public function destroy($id)
    {
        if (!$programme = Programme::find($id)) {
            abort(404, "No annualMember found with id $id");
        }
    
        $programme->delete();      
        return response()->json($programme);
    }
}


