<?php

namespace App\Http\Controllers\Liturgical;

use App\Http\Controllers\Controller;
use App\Models\Liturgical\EntryType;
use Illuminate\Http\Request;

class EntryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = EntryType::simplePaginate($req->has('limit') ? $req->limit : 15);
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

            $entryType = new EntryType();
            $entryType->title = $data['title'];
            $entryType->description = $data['description'];
             $entryType->save();
       
        return response()->json($entryType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liturgical\EntryType  $entryType
     * @return \Illuminate\Http\Response
     */
    public function show(EntryType $entryType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liturgical\EntryType  $entryType
     * @return \Illuminate\Http\Response
     */
    public function edit(EntryType $entryType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liturgical\EntryType  $entryType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $entryType = EntryType::find($id);
        if (!$entryType) {
            abort(404, "No entry Type found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required'
         ]);
        
        if ( $data['title']) $entryType->title = $data['title'];
        if ( $data['description']) $entryType->description = $data['description'];
        
        $entryType->update();

        return response()->json($entryType);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liturgical\EntryType  $entryType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$entryType = EntryType::find($id)) {
            abort(404, "No entry Type found with id $id");
        }

        $entryType->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = EntryType::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$entryType = EntryType::find($id)) {
            abort(404, "No entry type found with id $id");
        }
       return response()->json($entryType);
    }
}
