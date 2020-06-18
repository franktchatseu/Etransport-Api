<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Input;
use Illuminate\Http\Request;
use App\Models\APIError;

class InputController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Input::simplePaginate($req->has('limit') ? $req->limit : 15);
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
        $data = $req->only([
            'amount',
            'description',
            'reason',
            'start_date',
            'end_date',
            'nature_id',    
        ]);

        $this->validate($data, [
            'amount' => 'required',
            'reason' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            //'nature_id' => 'required:exists:nature,id'
         ]);

            $input = new Input();
            $input->amount = $data['amount'];
            $input->description = $data['description'];
            $input->reason = $data['reason'];
            $input->start_date = $data['start_date'];
            $input->end_date = $data['end_date'];
            $input->nature_id = $data['nature_id'];
            $input->save();
       
        return response()->json($input);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finance\Input  $input
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        if (!$input =Input::find($id)) {
            abort(404, "No input$input found with id $id");
        }
        return response()->json($input);
    }

    
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Input::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finance\Input  $input
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $input = Input::find($id);
        if (!$input) {
            abort(404, "No input found with id $id");
        }

        $data = $req->only([
            'amount',
            'description',
            'reason',
            'start_date',
            'end_date',
            'nature_id',    
        ]);

        $this->validate($data, [
            'amount' => 'required',
            'reason' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            //'nature_id' => 'required:exists:nature,id'
         ]);

        
        if (null !== $data['amount']) $input->amount = $data['amount'];
        if (null !== $data['description']) $input->description = $data['description'];
        if (null !== $data['reason']) $input->reason = $data['reason'];
        if (null !== $data['start_date']) $input->start_date = $data['start_date'];
        if (null !== $data['end_date']) $input->end_date = $data['end_date'];
        if (null !== $data['nature_id']) $input->nature_id = $data['nature_id'];
        
        $input->update();

        return response()->json($input);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance\Input  $input
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$input = Input::find($id)) {
            abort(404, "No input$input found with id $id");
        }

        $input->delete();      
        return response()->json();
    }
}

