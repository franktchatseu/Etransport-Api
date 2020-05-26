<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a list of album's description from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Album::simplePaginate($req->has('limit') ? $req->limit : 15);
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
     * Create an album on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'description' => 'required',
        ]);

            $album = new Album();
            $album->description = $data['description'];
            $album->save();
       
        return response()->json($album);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update an album on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $album = Album::find($id);
        if (!$album) {
            abort(404, "No album found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'description' => 'required',
        ]);

        if (null !== $data['description']) $album->description = $data['description'];
        
        $album->update();

        return response()->json($album);
    }

   /**
     * Remove an album from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$album = Album::find($id)) {
            abort(404, "No album found with id $id");
        }

        $album->delete();      
        return response()->json();
    }

     /**
     * Search an album from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Album::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    }

    /**
     * Find an album from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        if (!$album = Album::find($id)) {
            abort(404, "No album found with id $id");
        }
        return response()->json($album);
    }
}
