<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Planification\Transfert;
use Illuminate\Http\Request;

class TransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Transfert::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $data = $req->except('birth_certificate');
        $this->validate($data, [
            'activity' => 'required',
            'date' => 'required',
            'description' => 'required',
            'nature' => 'required',
            'activityPro' => 'required',
        ]);
        $Transfert = new Transfert();
        $Transfert->activity = $data['activity'];
        $Transfert->date = $data['date'];
        $Transfert->descritpion = $data['description'];
        $Transfert->activityPro = $data['activityPro'];
        $Transfert->place = $data['place'];
        $Transfert->nature = $data['nature'];

        $Transfert->save();
        return response()->json($Transfert);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);
        $data = Transfert::where($req->field, 'like', "%$req->q%")->get();
        return response()->json($data);
    }

    public function find($id)
    {
        if (!$Transfert = Transfert::find($id)) {
            abort(404, "No Transfert found with id $id");
        }
        return response()->json($Transfert);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planification\Transfert  $Transfert
     * @return \Illuminate\Http\Response
     */
    public function show(Transfert $Transfert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification\Transfert  $Transfert
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfert $Transfert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification\Transfert  $Transfert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $data = $req->except('birth_certificate');
        $this->validate($data, [
            'activity' => 'required',
            'date' => 'required',
            'activityPro' => 'required',
        ]);

        $Transfert = Transfert::find($id);
        if (!$Transfert) {
            abort(404, "No Transfert found with id $id");
        }

        if (null !== $data['activity']) $Transfert->activity = $data['activity'];
        if (null !== $data['date']) $Transfert->date = $data['date'];
        if (null !== $data['description']) $Transfert->description = $data['description'];
        if (null !== $data['activityPro']) $Transfert->activityPro = $data['activityPro'];
        if (null !== $data['place']) $Transfert->place = $data['place'];
        if (null !== $data['nature']) $Transfert->nature = $data['nature'];

        $Transfert->update();
        return response()->json($Transfert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planifications\Transfert  $Transfert
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$Transfert = Transfert::find($id)) {
            abort(404, "No Transfert found wiht id $id");
        }
        $Transfert->delete();
        return response()->json();
    }
}
