<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Person\MigrationParish;
use Illuminate\Http\Request;

class MigrationParishController extends Controller
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
        $this->validate($request->all(), [
            'user_id' => 'required:exists:users,id',
            'parish_id' => 'required',
            'is_active'=>'required',
            
        ]);

        $migparish = new MigrationParish();
        $migparish->user_id = $request->user_id;
        $migparish->parish_id = $request->parish_id;
        $migparish->is_active = $request->is_active;
        $migparish->save();

        return response()->json($migparish);

    }

    /**
     * Change of parish.
     *@author warren taba
     *@email fotiewarren50@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function migrateparish(Request $request,$id)
    {
        $migparish = MigrationParish ::find($id);

        if (!$migparish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USERPARISH_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->all();

        $this->validate($data, [
            'user_id' => 'required:number',
            'parish_id' => 'required:number',
        ]);

        MigrationParish::where(['user_id' => $id])
        ->update(['is_active' => false]);

        $migparish = new MigrationParish();
        $migparish->user_id = $request->user_id;
        $migparish->parish_id = $request->parish_id;
        $migparish->is_active = $request->is_active;
        $migparish->save();

        return response()->json($migparish);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\MigrationParish  $migrationParish
     * @return \Illuminate\Http\Response
     */
    public function show(MigrationParish $migrationParish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\MigrationParish  $migrationParish
     * @return \Illuminate\Http\Response
     */
    public function edit(MigrationParish $migrationParish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\MigrationParish  $migrationParish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MigrationParish $migrationParish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\MigrationParish  $migrationParish
     * @return \Illuminate\Http\Response
     */
    public function destroy(MigrationParish $migrationParish)
    {
        //
    }
}
