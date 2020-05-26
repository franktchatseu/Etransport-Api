<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Person\professions;
use Illuminate\Http\Request;

class ProfessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Professions::simplePaginate($req->has('limit') ? $req->limit : 15);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $this->validate($request->all(), [
            'name' => 'required',
            'description' => 'required',
            
        ]);

            $professions = new Professions();
            $professions->name = 'name';
            $professions->description = 'description';
            
            $professions->save();
       
        return response()->json($professions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\professions  $professions
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $professions = Professions::find($id);
        if (!$professions = Professions::find($id)) {
            abort(404, "No professions found with id $id");
        }
        return $professions;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\professions  $professions
     * @return \Illuminate\Http\Response
     */
    public function edit(professions $professions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\professions  $professions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $professions = Professions::find($id);
        if (!$professions) {
            abort(404, "No professions found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            
        ]);

        //upload image
        if ($file = $req->file('photo')) {
            $photo = app()->make('UploadService')->saveSingleImage($this, $req, 'photo', 'users');
            $data['photo'] =  $photo;
        }

        $professions->update();

        return response()->json($professions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\professions  $professions
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Professions::where($req->field, 'like', "%$req->q%")->get();

           // ->simplePaginate($req->has('limit') ? $req->limit : 15)

        return response()->json($data);
    }

    public function destroy($id)
    {
        if (!$professions = Professions::find($id)) {
            abort(404, "No profession found with id $id");
        }

        $professions->delete();      
        return response()->json();
    }

    
}