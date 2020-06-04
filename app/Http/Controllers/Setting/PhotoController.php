<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Photo::simplePaginate($req->has('limit') ? $req->limit : 15);
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
        $data = $req->except('');

        $this->validate($data, [
            'picture' => 'required',
            'description' => '',
            'album_id' => 'required'
        ]);

        $photo = new Photo();      
        $photo->picture = $this->uploadSingleFile($req, 'picture', 'photos', ['image', 'mimes:jpeg,png,jpg']);
        $photo->description = $data['description'];
        $photo->album_id = $data['album_id'];
        $photo->save();

        return response()->json($photo);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $photo = Photo::find($id);
        if (!$photo) {
            abort(404, "No sacrament photo found with id $id");
        }

        $data = $req->except('');

        $this->validate($data, [
            'picture' => 'required',
            'description' => '',
            'album_id' => 'required'
        ]);

        if (null !== $data['picture']) $photo->picture = $this->uploadSingleFile($req, 'picture', 'photos', ['image', 'mimes:jpeg,png,jpg']);;
        if (null !== $data['description']) $photo->description = $data['description'];
        if (null !== $data['album_id']) $photo->album_id = $data['album_id'];


        $photo->update();

        return response()->json($photo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$photo = Photo::find($id)) {
            abort(404, "No  photo found with id $id");
        }

        $photo->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Photo::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$photo = Photo::find($id)) {
            abort(404, "No Sacrament photo found with id $id");
        }
        return response()->json($photo);
    }

}
