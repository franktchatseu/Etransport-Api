<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Parish;
use Illuminate\Http\Request;
use App\Models\APIError;

class ParishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Parish::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
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
            'name' => 'required',
            'decision_creation' => 'required',
            'Pattern_date' => 'required',
            'nbr_of_structure' => 'required',
            'nbr_of_service' => 'required',
            'nbr_of_group' => 'required',
            'nbr_of_ceb' => 'required',
            'nbr_of_station' => 'required',
            'nbr_of_seminarist' => 'required'
         ]);

            $parish = new Parish();
            $parish->name = $data['name'];
            $parish->decision_creation = $data['decision_creation'];
            $parish->Pattern_date = $data['Pattern_date'];
            $parish->nbr_of_structure = $data['nbr_of_structure'];
            $parish->nbr_of_service = $data['nbr_of_service'];
            $parish->nbr_of_group = $data['nbr_of_group'];
            $parish->nbr_of_ceb = $data['nbr_of_ceb'];
            $parish->nbr_of_station = $data['nbr_of_station'];
            $parish->nbr_of_seminarist = $data['nbr_of_seminarist'];
            $parish->save();
       
        return response()->json($parish);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Parish   $parish 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $parish = Parish::find($id);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'decision_creation' => 'required',
            'Pattern_date' => 'required',
            'nbr_of_structure' => 'required',
            'nbr_of_service' => 'required',
            'nbr_of_group' => 'required',
            'nbr_of_ceb' => 'required',
            'nbr_of_station' => 'required',
            'nbr_of_seminarist' => 'required'
         ]);

        
         if (null !== $data['name']) $parish->name = $data['name'];
         if (null !== $data['decision_creation']) $parish->decision_creation = $data['decision_creation'];
         if (null !== $data['Pattern_date']) $parish->Pattern_date = $data['Pattern_date'];
         if (null !== $data['nbr_of_structure']) $parish->nbr_of_structure = $data['nbr_of_structure'];
         if (null !== $data['nbr_of_service']) $parish->nbr_of_service = $data['nbr_of_service'];
         if (null !== $data['nbr_of_group']) $parish->nbr_of_group = $data['nbr_of_group'];
         if (null !== $data['nbr_of_ceb']) $parish->nbr_of_ceb = $data['nbr_of_ceb'];
         if (null !== $data['nbr_of_station']) $parish->nbr_of_station = $data['nbr_of_station'];
         if (null !== $data['nbr_of_seminarist']) $parish->nbr_of_seminarist = $data['nbr_of_seminarist'];
        
        $parish->update();

        return response()->json($parish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\Parish  $parish
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parish = Parish::find($id);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $parish->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Parish::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $parish = Parish::find($id);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        
        return response()->json($parish);
    }

}
