<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Person\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Profession::simplePaginate($req->has('limit') ? $req->limit : 15);
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

            $professions = new Profession();
            $professions->name = 'name';
            $professions->description = 'description';
            
            $professions->save();
       
        return response()->json($professions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\profession  $professions
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $professions = Profession::find($id);
        if (!$professions = Profession::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PROFESSION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return $professions;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\Profession  $professions
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
     * @param  \App\Models\Person\Profession  $professions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $profession = Profession::find($id);
        if (!$profession) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PROFESSION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            
        ]);

        $profession->update();

        return response()->json($profession);
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

        $data = Profession::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function destroy($id)
    {
        if (!$profession = Profession::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PROFESSION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $profession->delete();      
        return response()->json();
    }

    
}
