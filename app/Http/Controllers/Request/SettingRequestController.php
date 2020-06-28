<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\SettingRequest;
use App\Models\APIError;


class SettingRequestController extends Controller
{
    public function index (Request $req)
    {
        $data = SettingRequest::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

 
    public function store(Request $request)
    {
        $data = $request->all();

        $this->validate($data, [
            'slug' => 'required',
            'amount' => 'required',
        ]);

        $data = array_merge($data, $request->only([
            'slug', 
            'amount', 
            'goodToKnow']));
        $SettingRequest = SettingRequest::create($data);
        return response()->json($SettingRequest);
    }


    public function update(Request $request, $id)
    {
        $SettingRequest = SettingRequest::find($id);
        if (!$SettingRequest) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->all();

        $this->validate($data, [
            'amount' => 'required',
        ]);

        $data = array_merge($data, $request->only([
            'amount', 
            'goodToKnow']));
        $SettingRequest = SettingRequest::create($data);
        return response()->json($SettingRequest);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evenement = SettingRequest::find($id);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $evenement->delete();      
        return response()->json();
    }


    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = SettingRequest::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $evenement = SettingRequest::find($id);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($evenement);
    }

    public function findSlug(Request $req, $slug)
    {
        $evenement = SettingRequest::whereSlug($slug)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($evenement);
    }
}
