<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Planification\Times;
use Illuminate\Http\Request;

class TimesController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        //
        
        $data = $req->all();

        $data= $req->validate( [
        
                'start_times' => 'required',
                'end_times' => 'required',
                'places' => 'required',
                'isfree' =>'required',
        ]);


            $time = new Times();
            $time->start_times = $data['start_times'];
            $time->end_times = $data['end_times'];
            $time->places = $data['places'];
            $time->isfree = $data['isfree'];
            $time->save();
       
        return response()->json($time);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planification\Times  $times
     * @return \Illuminate\Http\Response
     */
    public function show(Times $times)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification\Times  $times
     * @return \Illuminate\Http\Response
     */
    public function edit(Times $times)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification\Times  $times
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $time = Times::find($id);
        if (!$time) {
            abort(404, "No priestplaning found with id $id");
        }

        $data = $req->all();

        $data= $req->validate( [
            'start_times' => 'required',
            'end_times' => 'required',
            'places' => 'required',
            'isfree' =>'required',
         ]);

        
        if ( $data['start_times']) $time->start_times = $data['start_times'];
        if ( $data['end_times']) $time->end_times = $data['end_times'];
        if ( $data['places']) $time->places = $data['places'];
        if ( $data['isfree']) $time->isfree = $data['isfree'];

        
        $time->update();

        return response()->json($time);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planification\Times  $times
     * @return \Illuminate\Http\Response
     */
    public function destroy(Times $times)
    {
        //
    }
}
