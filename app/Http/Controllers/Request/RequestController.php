<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\IntentionMass;

class RequestController extends Controller
{
    // recuperation de toute les demandes de messes d'un utilisateur
    public function findAllDemande($id){

        //recuperation des demandes intentions de messe
        $intentions = IntentionMass::all();
        return response()->json($intentions, 200);

    }

}
