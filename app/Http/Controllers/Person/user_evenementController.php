<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Person\user_evenement;
use App\Models\Person\User;
use Illuminate\Http\Request;
use App\Models\APIError;

class user_evenementController extends Controller
{


    public function create(Request $request)
    {
        //
        $this->validate($request->all(), [
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            
        ]);
        //on met ajout les champs venant de la requette
        $evenemnts = new user_evenement();
        $evenemnts->user_utype_id = $request->user_utype_id;
        $evenemnts->name = $request->name;
        $evenemnts->description = $request->description;
        $evenemnts->save();

        return response()->json($evenemnts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\user_evenement  $user_evenement
     * @return \Illuminate\Http\Response
     */
    public function get(Request $req)
    {
        //
        $data = user_evenement::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\user_evenement  $user_evenement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $evenemnts = user_evenement::find($id);
        if (!$evenemnts) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_USER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $this->validate($request->all(), [
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            
        ]);
        //on met ajout les champs venant de la requette
        $evenemnts->name = $request->name;
        $evenemnts->description = $request->description;
        $evenemnts->update();

        return response()->json($evenemnts);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\user_evenement  $user_evenement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (!$user_evenement =user_evenement::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $user_evenement->delete();      
        return response()->json($user_evenement);
    }

    //methode de recherche
    public function find($id)
    {
        if(!$evenements = user_evenement::find($id)){    
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($evenements);
    }
    // recuperation de tous les evenements d'un utilisaue
    public function findByUserId(Request $req,$user_id)
    {
        if(!$user = User::where($user_id)){    
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $evenements = user_evenement::select('user_evenements.*')
        ->join('user_utypes', 'user_evenements.user_utype_id', '=', 'user_utypes.id')
        ->where(['user_utypes.user_id' => $user_id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($evenements);
    }
}
