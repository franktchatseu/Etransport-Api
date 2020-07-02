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
        $formmig->user_utype_id = $data['user_utype_id'];
        $formmig->message = $data['message'];
        $formmig->save();

        return response()->json($formmig);
    }

     /**
     * Search a person from database
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = FormMigration::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
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
        if (!$formmig = FormMigration::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("FORMMIGRATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $formmig->delete();      
        return response()->json();
    }
}
