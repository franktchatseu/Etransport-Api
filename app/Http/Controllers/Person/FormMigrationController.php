<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Person\FormMigration;
use Illuminate\Http\Request;

class FormMigrationController extends Controller
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
        $data = $request->except('piece');
        $this->validate($data, [
            'user_utype_id' => 'required',
            'reason' => 'required',
            'message' => 'required'
        ]);

        $formmig = new FormMigration();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\FormMigration  $formMigration
     * @return \Illuminate\Http\Response
     */
    public function show(FormMigration $formMigration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\FormMigration  $formMigration
     * @return \Illuminate\Http\Response
     */
    public function edit(FormMigration $formMigration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\FormMigration  $formMigration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormMigration $formMigration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\FormMigration  $formMigration
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormMigration $formMigration)
    {
        //
    }
}
