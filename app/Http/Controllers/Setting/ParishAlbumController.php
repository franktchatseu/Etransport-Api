<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\ParishAlbum;
use Illuminate\Http\Request;

class ParishAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = ParishAlbum::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'album_id' => 'required:exists:albums,id',
            'parish_id' => 'required:exists:parishs,id'
            
         ]);


            $parishAlbum = new ParishAlbum();
            $parishAlbum->album_id = $data['album_id'];
            $parishAlbum->parish_id = $data['parish_id'];
            $parishAlbum->save();
       
        return response()->json($parishAlbum);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting\ParishAlbum  $parishAlbum
     * @return \Illuminate\Http\Response
     */
    public function show(ParishAlbum $parishAlbum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting\ParishAlbum  $parishAlbum
     * @return \Illuminate\Http\Response
     */
    public function edit(ParishAlbum $parishAlbum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting\ParishAlbum  $parishAlbum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $parishAlbum = ParishAlbum::find($id);
        if (!$parishAlbum) {
            abort(404, "No parishAlbum found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'album_id' => 'required:exists:albums,id',
            'parish_id' => 'required:exists:parishs,id'
            
         ]);

        
         if ( $data['album_id']) $parishAlbum->album_id = $data['album_id'];
         if ( $data['parish_id']) $parishAlbum->parish_id = $data['parish_id'];

        
        $parishAlbum->update();

        return response()->json($parishAlbum);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting\ParishAlbum  $parishAlbum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$parishAlbum = ParishAlbum::find($id)) {
            abort(404, "No user found with id $id");
        }

        $parishAlbum->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = ParishAlbum::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$parishalbum = ParishAlbum::find($id)) {
            abort(404, "No parishalbum found with id $id");
        }
        return response()->json($parishalbum);
    }

    public function findParishAlbum(Request $req, $id)
    {
        $album = ParishAlbum::select('parish_albums.*', 'parish_albums.id as palbum_id', 'albums.*', 'albums.id as id_album')
        ->join('albums', 'parish_albums.album_id', '=', 'albums.id')
        ->where(['parish_albums.parish_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($album);
    }
}
