<?php

namespace App\Http\Controllers\Liturgical;

use App\Http\Controllers\Controller;
use App\Models\Liturgical\LiturgicalTypeEntryType;
use Illuminate\Http\Request;

class LiturgicalTypeEntryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = LiturgicalTypeEntryType::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'type_id' => 'required:exists:liturgical_types,id',
         ]);


            $liturgicalTypeEntryType = new LiturgicalTypeEntryType();
             $liturgicalTypeEntryType->type_id = $data['type_id'];
            $liturgicalTypeEntryType->entry_type_id = $data['entry_type_id'] ?? null;
            $liturgicalTypeEntryType->save();
       
        return response()->json($liturgicalTypeEntryType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liturgical\LiturgicalTypeEntryType  $liturgicalTypeEntryType
     * @return \Illuminate\Http\Response
     */
    public function show(LiturgicalTypeEntryType $liturgicalTypeEntryType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liturgical\LiturgicalTypeEntryType  $liturgicalTypeEntryType
     * @return \Illuminate\Http\Response
     */
    public function edit(LiturgicalTypeEntryType $liturgicalTypeEntryType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liturgical\LiturgicalTypeEntryType  $liturgicalTypeEntryType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $liturgical = LiturgicalTypeEntryType::find($id);
        if (!$liturgical) {
            abort(404, "No liturgical type entry type found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'type_id' => 'required:exists:liturgical_types,id',
            'entry_type_id' => 'required:exists:entry_types,id'
         ]);


        
         if ( $data['type_id']) $liturgical->type_id = $data['type_id'];
        if ( $data['entry_type_id']) $liturgical->entry_type_id = $data['entry_type_id'];

        
        $liturgical->update();

        return response()->json($liturgical);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liturgical\LiturgicalTypeEntryType  $liturgicalTypeEntryType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$liturgical = LiturgicalTypeEntryType::find($id)) {
            abort(404, "No liturgical found with id $id");
        }

        $liturgical->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = LiturgicalTypeEntryType::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$liturgical = LiturgicalTypeEntryType::find($id)) {
            abort(404, "No liturgical found with id $id");
        }
        return response()->json($liturgical);
    }

    public function TypeAndEntry(Request $req)
    {
        $liturgical = LiturgicalTypeEntryType::select('liturgical_types.title as type',
                                                      'entry_types.title as entry',
                                                      'liturgical_type_entry_types.*')
                                            ->join('liturgical_types', 'liturgical_type_entry_types.type_id', '=', 'liturgical_types.id')
                                            ->join('entry_types', 'liturgical_type_entry_types.entry_type_id', '=', 'entry_types.id')
                                            
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($liturgical);
    }
}