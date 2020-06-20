<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use App\Models\Association\Evenement;
use Illuminate\Http\Request;
use App\Models\APIError;

class EvenementController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Evenement::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'raison' => 'required',
            'description' => 'required',
            'start_event_date' => 'required',
            'end_event_date' => '',
            'start_hour' => '',
            'end_hour' => '',
            'association_id' => 'required',
        ]);

            $evenement = new Evenement();
            $evenement->raison = $data['raison'];
            $evenement->description = $data['description'];
            $evenement->start_event_date = $data['start_event_date'];
            $evenement->end_event_date = $data['end_event_date'];
            $evenement->start_hour = $data['start_hour'];
            $evenement->end_hour = $data['end_hour'];
            $evenement->association_id = $data['association_id'];
            $evenement->save();
       
        return response()->json($evenement);
    }

   /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $evenement = Evenement::find($id);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            
            'raison' => 'required',
            'description' => 'required',
            'start_event_date' => 'required',
            'end_event_date' => '',
            'start_hour' => '',
            'end_hour' => '',
            'association_id' => 'required',
        ]);

        if (null !== $data['raison']) $evenement->raison = $data['raison'];
        if (null !== $data['description']) $evenement->description = $data['description'];
        if (null !== $data['start_event_date']) $evenement->start_event_date = $data['start_event_date'];
        if (null !== $data['end_event_date']) $evenement->end_event_date = $data['end_event_date'];
        if (null !== $data['start_hour']) $evenement->start_hour = $data['start_hour'];
        if (null !== $data['end_hour']) $evenement->end_hour = $data['end_hour'];
        if (null !== $data['association_id']) $evenement->association_id = $data['association_id'];

        $evenement->update();

        return response()->json($evenement);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evenement = Evenement::find($id);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $evenement->delete();      
        return response()->json();
    }
/**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Evenement::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $evenement = Evenement::find($id);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($evenement);
    }
/* 
    public function findAnnuelMembers(Request $req, $id)
    {
        $Evenement = Evenement::find($id);
        if (!$Evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Evenement_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $Evenements = AnnualMember::whereEvenementId($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($Evenements);
    }  */

}
