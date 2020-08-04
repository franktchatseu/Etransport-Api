<?php

namespace App\Http\Controllers\Module3;

use App\Http\Controllers\Controller;
use App\Models\Module3\CaracterTechTwo;
use Illuminate\Http\Request;
use App\Models\APIError;


class caracterTechTwoController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //
        $data = CaracterTechTwo::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->all();
        $this->validate($data, [
            'semi_trailer_number' => 'required',
            'stepper_id' => 'required',
            'essieux_tracteur_porteur_number' => 'required',
            'place_nber' => 'required',
            'interne_code' => 'required',
            'effective_date' => 'required',
            'fuel' => 'required',
            'color' => 'required',
            'option' => 'required',
            'purchase_value' => 'required',
            'kilometrage' => 'required',
            'consommation_min' => 'required',
            'consommation_max' => 'required',
            'etat' => 'required',
        ]);

        $caracter = new CaracterTechTwo();
        $caracter->semi_trailer_number = $data['semi_trailer_number'];
        $caracter->stepper_id = $data['stepper_id'];
        $caracter->essieux_tracteur_porteur_number = $data['essieux_tracteur_porteur_number'];
        $caracter->place_nber = $data['place_nber'];
        $caracter->interne_code = $data['interne_code'];
        $caracter->effective_date = $data['effective_date'];
        $caracter->fuel = $data['fuel'];
        $caracter->color = $data['color'];
        $caracter->option = $data['option'];
        $caracter->purchase_value = $data['purchase_value'];
        $caracter->kilometrage = $data['kilometrage'];
        $caracter->consommation_min = $data['consommation_min'];
        $caracter->consommation_max = $data['consommation_max'];
        $caracter->etat = $data['etat'];
        $caracter->save();
       
        return response()->json($caracter);
    }

    /**
     * Search the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = CaracterTechTwo::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Bill the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $taractertechtwo = CaracterTechTwo::where('stepper_id',$id)->first();
        if (!$taractertechtwo) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CARACTER_TECH_TWO_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        return response()->json($taractertechtwo);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $caracter = CaracterTechTwo::where('stepper_id',$id)->first();
        if (!$caracter) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CARACTER_TECH_TWO_NOT_FOUND");

            return response()->json($apiError, 404);
        }

        $data = $request->all();

        if ( $request->semi_trailer_number) $caracter->semi_trailer_number = $data['semi_trailer_number'];
        if ( $request->essieux_tracteur_porteur_number) $caracter->essieux_tracteur_porteur_number = $data['essieux_tracteur_porteur_number'];
        if ( $request->place_nber) $caracter->place_nber = $data['place_nber'];
        if ( $request->interne_code) $caracter->interne_code = $data['interne_code'];
        if ( $request->effective_date) $caracter->effective_date = $data['effective_date'];
        if ( $request->fuel) $caracter->fuel = $data['fuel'];
        if ( $request->color) $caracter->color = $data['color'];
        if ( $request->option) $caracter->option = $data['option'];
        if ( $request->purchase_value) $caracter->purchase_value = $data['purchase_value'];
        if ( $request->kilometrage) $caracter->kilometrage = $data['kilometrage'];
        if ( $request->consommation_min) $caracter->consommation_min = $data['consommation_min'];
        if ( $request->consommation_max) $caracter->consommation_max = $data['consommation_max'];
        if ( $request->etat) $caracter->etat = $data['etat'];

        $caracter->update();

        return response()->json($caracter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $taractertechtwo = CaracterTechTwo::find($id);
        if (!$taractertechtwo) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CARACTER_TECH_TWO_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $taractertechtwo->delete();      
        return response()->json();
    }
}
