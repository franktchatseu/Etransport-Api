<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Planification\AssociationPlanning;
use Illuminate\Http\Request;

class AssociationPlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = AssociationPlanning::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'association_id' => 'required:exists:users,id',
            'planing_id' => 'required:exists:planings,id'           
         ]);


            $associationPlanning = new AssociationPlanning();
            $associationPlanning->association_id = $data['association_id'];
            $associationPlanning->planing_id = $data['planing_id'];
            $associationPlanning->save();
       
        return response()->json($associationPlanning);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planification\AssociationPlanning  $associationPlanning
     * @return \Illuminate\Http\Response
     */
    public function show(AssociationPlanning $associationPlanning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planification\AssociationPlanning  $associationPlanning
     * @return \Illuminate\Http\Response
     */
    public function edit(AssociationPlanning $associationPlanning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planification\AssociationPlanning  $associationPlanning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $associationPlanning = AssociationPlanning::find($id);
        if (!$associationPlanning) {
            abort(404, "No associationplaning found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
           'association_id' => 'required:exists:associations,id',
            'planing_id' => 'required:exists:planings,id'
         ]);

        
        if (null !== $data['association_id']) $associationPlanning->association_id = $data['association_id'];
        if (null !== $data['planing_id']) $associationPlanning->planing_id = $data['planing_id'];

        
        $associationPlanning->update();

        return response()->json($associationPlanning);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planification\AssociationPlanning  $associationPlanning
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$associationPlanning = AssociationPlanning::find($id)) {
            abort(404, "No associationPlanning found with id $id");
        }

        $associationPlanning->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = AssociationPlanning::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$associationPlanning = AssociationPlanning::find($id)) {
            abort(404, "No associationPlanning found with id $id");
        }
        return response()->json($associationPlanning);
    }

    public function findAssociationPlaning(Request $req, $id)
    {
        $planing = AssociationPlanning::select('association_planings.*', 'association_planings.id as aplaning_id', 'planings.*', 'planings.id as id_planing')
        ->join('planings', 'association_planings.planing_id', '=', 'planings.id')
        ->where(['association_planings.association_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($planing);
    }
}
