<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Quarter;
use Illuminate\Http\Request;

class QuarterController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Quarter::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'title' => 'required',
            'description' => 'required',
            'debut_date' => 'required',
            'end_date' => 'required'
        ]);

            $quarter = new Quarter();
            $quarter->title = $data['title'];
            $quarter->description = $data['description'];
            $quarter->debut_date = $data['debut_date'];
            $quarter->end_date = $data['end_date'];
            $quarter->save();
       
        return response()->json($quarter);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Quarter $quarter)
    {
        //
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Quarter $quarter)
    {
        //
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
        $quarter = Quarter::find($id);
        if (!$quarter) {
            abort(404, "No priest found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required',
            'debut_date' => 'required',
            'end_date' => 'required'
        ]);

        if (null !== $data['title']) $quarter->title = $data['title'];
        if (null !== $data['description']) $quarter->description = $data['description'];
        if (null !== $data['debut_date']) $quarter->debut_date = $data['debut_date'];
        if (null !== $data['end_date']) $quarter->end_date = $data['end_date'];

        $quarter->update();

        return response()->json($quarter);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$quarter = Quarter::find($id)) {
            abort(404, "No priest found with id $id");
        }

        $quarter->delete();      
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

        $data = Quarter::where($req->field, 'like', "%$req->q%")
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
        if (!$quarter = Quarter::find($id)) {
            abort(404, "No priest found with id $id");
        }
        return response()->json($quarter);
    }
}
