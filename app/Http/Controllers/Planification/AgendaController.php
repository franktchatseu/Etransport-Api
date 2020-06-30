<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Planification\Agenda;
use Illuminate\Http\Request;
use App\Models\Setting\Parish;
use App\Models\APIError;
use Carbon\Carbon;
use DB;

class AgendaController extends Controller
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

    //methode qui retourne les agenda d'une paroisse selon une periode

    public function getAgendaByHebdo(Request $req, $parish_id){

        //calcul de intervalle de date de la semaine
        $parish= Parish::find($parish_id);
      //  dd($parish);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            $apiError->setMessage("la paroisse n'a pas ete trouvé");
            return response()->json($apiError, 404);
        }
        $now_date =  Carbon::now();
        $hebdo_date =Carbon::now()->subDays(7);
        //dd($hebdo_date);
        $agendas = DB:: table('agendas')->where('parish_id',$parish->id)->whereBetween('date_agenda', array($hebdo_date, $now_date))->orderBy('date_agenda','desc')->get()->groupBy(function($date) {
            return Carbon::parse($date->date_agenda)->format('W'); // grouping by years
            //return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        return response()->json($agendas);
    }

    //mensuelle
    public function getAgendaByMensuelle(Request $req,$parish_id){

        //calcul de intervalle de date de la semaine
        $parish= Parish::find($parish_id);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            $apiError->setMessage("la paroisse n'a pas ete trouvé");
            return response()->json($apiError, 404);
        }

        $now_date =  Carbon::now();
        $hebdo_date =Carbon::now()->subDays(30);
        //dd($hebdo_date);
        $agendas = DB:: table('agendas')->where('parish_id',$parish->id)->whereBetween('date_agenda', array($hebdo_date, $now_date))->orderBy('date_agenda','desc')->get()->groupBy(function($date) {
            return Carbon::parse($date->date_agenda)->format('m'); // grouping by years
            //return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        return response()->json($agendas);
    }

    //trimestrielle
    public function getAgendaByTrimestre(Request $req,  $parish_id){
        $parish= Parish::find($parish_id);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            $apiError->setMessage("la paroisse n'a pas ete trouvé");
            return response()->json($apiError, 404);
        }
        
        //calcul de intervalle de date de la semaine
        $now_date =  Carbon::now();
        $hebdo_date =Carbon::now()->subDays(90);
        //dd($hebdo_date);
        $agendas = DB:: table('agendas')->where('parish_id',$parish->id)->whereBetween('date_agenda', array($hebdo_date, $now_date))->orderBy('date_agenda','desc')->get()->groupBy(function($date) {
            return Carbon::parse($date->date_agenda)->format('m'); // grouping by years
            //return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        return response()->json($agendas);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planification\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show(Agenda $agenda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function edit(Agenda $agenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agenda $agenda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planification\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agenda $agenda)
    {
        //
    }
}
