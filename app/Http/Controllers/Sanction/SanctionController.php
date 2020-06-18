<?php

namespace App\Http\Controllers\Sanction;

use App\Http\Controllers\Controller;
use App\Models\Sanction\Sanction;
use Illuminate\Http\Request;

class SanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Sanction::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'type_id' => 'required:exists:punishment_types,id'
         ]);


            $sanction = new Sanction();
            $sanction->title = $data['title'];
            $sanction->description = $data['description'];
            $sanction->type_id = $data['type_id'];
            $sanction->save();
       
        return response()->json($sanction);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sanction\Sanction  $sanction
     * @return \Illuminate\Http\Response
     */
    public function show(Sanction $sanction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sanction\Sanction  $sanction
     * @return \Illuminate\Http\Response
     */
    public function edit(Sanction $sanction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sanction\Sanction  $sanction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $sanction = Sanction::find($id);
        if (!$sanction) {
            abort(404, "No sanction found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required',
            'type_id' => 'required:exists:punishment_types,id'
         ]);

        
        if ( $data['title']) $sanction->title = $data['title'];
        if ( $data['description']) $sanction->description = $data['description'];
        if ( $data['type_id']) $sanction->type_id = $data['type_id'];

        
        $sanction->update();

        return response()->json($sanction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sanction\Sanction  $sanction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$sanction = Sanction::find($id)) {
            abort(404, "No user found with id $id");
        }

        $sanction->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Sanction::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$sanction = Sanction::find($id)) {
            abort(404, "No user found with id $id");
        }
        return response()->json($sanction);
    }
}
