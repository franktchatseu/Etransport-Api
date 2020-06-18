<?php

namespace App\Http\Controllers\Sanction;

use App\Http\Controllers\Controller;
use App\Models\Sanction\PunishmentType;
use Illuminate\Http\Request;
use App\Models\Sanction\Sanction;

class PunishmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = PunishmentType::simplePaginate($req->has('limit') ? $req->limit : 15);
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
    public function store(Request $req)
    {
        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $punishmentType = new PunishmentType();
        $punishmentType->title = $data['title'];
        $punishmentType->description = $data['description'];
        $punishmentType->save();

        return response()->json($punishmentType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sanction\PunishmentType  $punishmentType
     * @return \Illuminate\Http\Response
     */
    public function show(PunishmentType $punishmentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sanction\PunishmentType  $punishmentType
     * @return \Illuminate\Http\Response
     */
    public function edit(PunishmentType $punishmentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sanction\PunishmentType  $punishmentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $punishmentType = PunishmentType::find($id);
        if (!$punishmentType) {
            abort(404, "No punishment type found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required'
        ]);


        if ( $data['title']) $punishmentType->title = $data['title'];
        if ( $data['description']) $punishmentType->description = $data['description'];


        $punishmentType->update();

        return response()->json($punishmentType);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sanction\PunishmentType  $punishmentType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$punishmentType = PunishmentType::find($id)) {
            abort(404, "No user found with id $id");
        }

        $punishmentType->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = PunishmentType::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$punishmentType = PunishmentType::find($id)) {
            abort(404, "No Pushnishment found with id $id");
        }
        return response()->json($punishmentType);
    }

    public function findSanctions(Request $req, $id)
    {
        if (!$sanctions = Sanction::whereTypeId($id)->simplePaginate($req->has('limit') ? $req->limit : 15)) {
            abort(404, "No Sanctions for pushnishmentType with id $id found ");
        }
        return response()->json($sanctions);
    }
}
