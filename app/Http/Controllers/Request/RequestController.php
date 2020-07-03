<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\IntentionMass;
use App\Models\Request\RequestMass;
use App\Models\Request\MakingAppointment;
use App\Models\Request\AnointingSick;
use App\Models\Request\ReportProblem;



class RequestController extends Controller
{
    // recuperation de toute les demandes de messes d'un utilisateur
    public function findAllDemande($id){

        //recuperation des demandes intentions de messe
        $intentions = IntentionMass::select('intention as description','mass_id','amount','created_at')->wherePersonId($id)->get();
        //messe a domicile
        $messes = RequestMass::select('description','amount','created_at','hour','place')->wherePersonId($id)->get();
        //prise de rendezvous
        $prise_rendezvous = MakingAppointment::select('comment as description','created_at','hour')->wherePersonId($id)->get();
        //onction des malages
        $onction_malade = AnointingSick::select('comment as description','created_at','hour','assisted_person')->wherePersonId($id)->get();
        //signaler un problemes
        $signaler_problem = ReportProblem::select('details as description','concern as concerne','nature','image','created_at')->wherePersonId($id)->get();

        
        return response()->json([
            'intentions_messe' => $intentions,
            'messes' => $messes,
            'prise_rendezvous' => $prise_rendezvous,
            'onction_malade' => $onction_malade,
            'signaler_problem' => $signaler_problem,
        ]);

    }

}
