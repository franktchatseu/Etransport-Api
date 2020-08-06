<?php

namespace App\Http\Controllers;
use App\Models\Module1\Stepper_Main;
use App\Models\Module2\Stepper_Driver;
use App\Models\Module3\steppertree;
use App\Models\Module4\TransportElement;



use App\Models\Person\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
        $data = $request->except('files');

        $this->validate($data, [
            'login' => 'required|min:2',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'password' => 'required',
	      
        ]);
        $user= User::create([
            'first_name'=> $request->first_name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'last_name'=> $request->last_name,
            'login'=> $request->login,
        ]);

        return response()->json($user);
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //recuperation de tous les donnees utiles
    public function getDonneeUtile(){

        //recuperation de du nombre total
        $count_transporters =  Stepper_Main::select(Stepper_Main::raw('count(*) as total_transporteur'))
        ->join('info_entreprise_ones','info_entreprise_ones.stepper_main_id','=','stepper_mains.id')->first();
        $count_drivers =  Stepper_Driver::select(Stepper_Driver::raw('count(*) as tatal_chauffeur'))
        ->join('general_infos','general_infos.stepper_id','=','stepper_drivers.id')->first();
        $count_cars =  steppertree::select(steppertree::raw('count(*) as total_engin'))
        ->join('caracter_tech_ones','caracter_tech_ones.stepper_id','=','stepper_trees.id')
        ->first();
        $count_element =  TransportElement::select(TransportElement::raw('count(*) as total_element'))->first();

        return response()->json([

            "total_transporteur" => $count_transporters,
            "total_chauffeur" => $count_drivers,
            "total_engin" => $count_cars,
            "total_element" => $count_element,

        ]);
    }
}
