<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Authorization;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    { 
        {
            $data = Authorization::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = $request->only([
            'name',
            'description',
            'documents',

        ]);

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
            'documents' => 'required',
        ]);

        $filePaths = $this->saveMultipleImages($this, $request, 'documents', 'authorizations');
        $data['documents'] = json_encode(['images' => $filePaths]);

        $authorization = new Authorization();
        $authorization->name = $data['name'];
        $authorization->description = $data['description'];
        $authorization->documents = $data['documents'];

        $authorization->save();

        return response()->json($authorization);
    }


    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Authorization::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }

    public function find($id)
    {
        $authorization = Authorization::find($id);
        if (!$authorization) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("AUTHORIZATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($authorization);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\Authorization  $authorization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $authorization = Authorization::find($id);
        if (!$authorization) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("AUTHORIZATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->only([
            'name',
            'description',
            'documents'
        ]);

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
            'documents' => 'required',
        ]);

        //upload document
        $filePaths = $this->saveMultipleImages($this, $request, 'documents', 'authorizations');
        $data['documents'] = json_encode(['images' => $filePaths]);

        if ( $data['name'] ?? null) {
            $authorization->name = $data['name'];
        }
        if ( $data['description'] ?? null) {
            $authorization->description = $data['description'];
        }
        if ( $data['documents'] ?? null) {
            $authorization->documents = $data['documents'];
        }

        $authorization->update();

        return response()->json($authorization);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catechesis\Authorization  $authorization
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $authorization = Authorization::find($id);
        if (!$authorization) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("AUTHORIZATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $authorization->delete();
        return response()->json();
    }
}
