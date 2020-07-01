<?php

namespace App\Http\Controllers\Setting;

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
        
    ;
    }


    /**
     * Remove the specified resource from storage.
     **by tchamou:tchamou tchamouramses@gmail.com
     * @param  \App\Models\Catechesis\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {

    }
    
    public function destroy($id)
    {
        
    }
}


