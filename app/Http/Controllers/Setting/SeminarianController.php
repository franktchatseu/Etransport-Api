<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Seminarian;
use App\Models\Setting\Parish;
use Illuminate\Http\Request;
use App\Models\APIError;


class SeminarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Seminarian::simplePaginate($req->has('limit')? $req->limit : 15);

        return response()->json($data);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q'=>'description',
            'field'=>'description'
        ]);
    
        $data = Seminarian::where($req->field, 'like',"%$req->q%")->simplePaginate($req->has('limit') ? $req->limit : 15);
    
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'description',
            'picture',
            'parish_id',
            'phone'
        ]);

        $this->validate($data, [
            'name'=>'required',
            'description'=>'required',
            'parish_id'=>'required',
            'phone'=>'required'
        ]);

        $data['picture'] = '';
        //upload image
        if ($file = $request->file('files')) {
            $filePaths = $this->saveSingleImage($this, $request, 'files', 'seminarians');
            $data['picture'] = json_encode(['images' => $filePaths]);
        }

        $seminarian = new Seminarian();
        $seminarian->name = $data['name'];
        $seminarian->description = $data['description'];
        $seminarian->parish_id = $data['parish_id'];
        $seminarian->picture = $data['picture'];
        $seminarian->phone = $data['phone'];

        $seminarian->save();

        return response()->json($seminarian);
        
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting\Seminarian  $seminarian
     * @return \Illuminate\Http\Response
     */
    public function find($id){
        $seminarian = Seminarian::find($id);
        if (!$seminarian) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SEMINARIAN_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($seminarian);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting\Seminarian  $seminarian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seminarian = Seminarian::find($id);
        if (!$seminarian) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SEMINARIAN_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->only([
            'picture',
            'name',
            'description',
            'parish_id',
            'phone'
        ]);

        $this->validate($data, [
            'description' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ]);

        //upload image
        if ($file = $request->file('files')) {
            $filePaths = $this->saveSingleImage($this, $request, 'files', 'users');
            $data['picture'] = json_encode(['images' => $filePaths]);
        }

        if ( $data['phone'] ?? null) {
            $seminarian->phone = $data['phone'];
        }
        if ( $data['name'] ?? null) {
            $seminarian->name = $data['name'];
        }
        if ( $data['parish_id'] ?? null) {
            $seminarian->name = $data['parish_id'];
        }
        if ( $data['description'] ?? null) {
            $seminarian->description = $data['description'];
        }
        $seminarian->update();

        return response()->json($seminarian);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting\Seminarian  $seminarian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seminarian = Seminarian::find($id);
        if (!$seminarian) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SEMINARIAN_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $seminarian->delete();
        return response()->json();
    }

    public function parishSeminarians(Request $req, $id)
    {
        $parish = Parish::find($id);
        $data = Seminarian::where('parish_id', '=', $id)->simplePaginate($req->has('limit')? $req->limit : 15);
        return response()->json($data);
    }
}
