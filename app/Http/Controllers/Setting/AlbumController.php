<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\APIError;
use App\Models\Setting\Album;
use App\Models\Setting\Photo;
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
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ALBUM_NOT_FOUND");
            return response()->json($apiError, 404);
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
        $album = Album::find($id);
        if (!$album) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ALBUM_NOT_FOUND");
            return response()->json($apiError, 404);
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
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

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
        $album = Album::find($id);
        if (!$album) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ALBUM_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($album);
    }

    public function findPhoto(Request $req, $id){
        if (!$photo = Photo::whereAlbumId($id)->simplePaginate($req->has('limit') ? $req->limit : 15)) {
            abort(404, "No photo with id $id found ");
        }
        return response()->json($photo);
    }
}
