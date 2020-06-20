<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\Request\IntentionMass;
use Illuminate\Http\Request;

class IntentionMassController extends Controller
{
    /**
     * Display a list of intension mass from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = IntentionMass::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
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
     * Create an intention mass on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'ammount' => 'required',
            'request_date' => 'required',
            'intention' => 'required',
            'status' => 'required',
        ]);

            $intentionMass = new IntentionMass();
            $intentionMass->ammount = $data['ammount'];
            $intentionMass->request_date = $data['request_date'];
            $intentionMass->intention = $data['intention'];
            $intentionMass->status = $data['status'];
 
            
            $intentionMass->save();
       
        return response()->json($intentionMass);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request\IntentionMass  $intentionMass
     * @return \Illuminate\Http\Response
     */
    public function show(IntentionMass $intentionMass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request\IntentionMass  $intentionMass
     * @return \Illuminate\Http\Response
     */
    public function edit(IntentionMass $intentionMass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request\IntentionMass  $intentionMass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntentionMass $intentionMass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request\IntentionMass  $intentionMass
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntentionMass $intentionMass)
    {
        //
    }

    /**
     * Update an intention mass on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $intentionMass = IntentionMass::find($id);
        if (!$intentionMass) {
            abort(404, "No intentionMass found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'ammount' => 'required',
            'request_date' => 'required',
            'intention' => 'required',
            'status' => 'required',
        ]);
        
        if (null !== $data['ammount'])  $intentionMass->ammount = $data['ammount'];
        if (null !== $data['request_date'])  $intentionMass->request_date = $data['request_date'];
        if (null !== $data['intention'])  $intentionMass->intention = $data['intention'];
        if (null !== $data['status'])  $intentionMass->status = $data['status'];


        $intentionMass->update();

        return response()->json($intentionMass);
    }

    /**
     * Remove an intention mass from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$intentionMass = IntentionMass::find($id)) {
            abort(404, "No intentionMass found with id $id");
        }

        $intentionMass->delete();      
        return response()->json();
    }

    /**
     * Search an intention mass from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = IntentionMass::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    }

    /**
     * Find an intention mass from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        if (!$intentionMass = IntentionMass::find($id)) {
            abort(404, "No intentionMass found with id $id");
        }
        return response()->json($intentionMass);
    }
}
