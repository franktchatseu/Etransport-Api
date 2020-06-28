<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\ReportProblem;
use App\Models\APIError;
use App\Models\Person\User;

class ReportProblemController extends Controller
{
    public function index (Request $req)
    {
        $data = ReportProblem::simplePaginate($req->has('limit') ? $req->limit : 15);
        foreach($data as $assoc){
            $user = User::select('login', 'avatar')
            ->join('user_utypes', 'user_utypes.type_id', '=', 'users.id')
            ->join('utypes', 'user_utypes.type_id', '=', 'utypes.id')
            ->where([
                    'utypes.id' => $assoc->utype_id, 
                    'user_utypes.is_active' => true
            ])->get();
            $assoc['user'] = $user;
        }
        return response()->json($data);
        
    }


    public function store(Request $request)
    {
        $data = $request->except('image');

        $this->validate($data, [
            'utype_id' => 'required',
            'concerne' => 'required',
        ]);

        if ($request->has('image')) {
            $filePaths = $this->saveSingleImage($this, $request, 'image', 'archivings');
            $data['image'] = json_encode(['images' => $filePaths]);
        }

        $data = array_merge($data, $request->only([
            'utype_id', 
            'concerne', 
            'nature', 
            'details', 
            'state']));
        $ReportProblem = ReportProblem::create($data);
        $ReportProblem->image = json_decode($ReportProblem->image);
        return response()->json($ReportProblem);
    }


    public function update(Request $request, $id)
    {
        $assoc = ReportProblem::find($id);
        if (!$assoc) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ASSOCIATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $this->validate($request->all(), [
            'utype_id' => 'required',
            'concerne' => 'required',
        ]);
        $data = [];
        if ($request->has('image')) {
            $filePaths = $this->saveSingleImage($this, $request, 'image', 'archivings');
            $data['image'] = json_encode(['images' => $filePaths]);
        }

        $data = array_merge($data, $request->only([
            'utype_id', 
            'concerne', 
            'nature', 
            'details', 
            'state']));
        $assoc->update($data);
        return response()->json($assoc);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evenement = ReportProblem::find($id);
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

        $data = ReportProblem::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
            foreach($data as $assoc){
            $user = User::select('login', 'avatar')
            ->join('user_utypes', 'user_utypes.type_id', '=', 'users.id')
            ->join('utypes', 'user_utypes.type_id', '=', 'utypes.id')
            ->where([
                    'utypes.id' => $assoc->utype_id, 
                    'user_utypes.is_active' => true
            ])->get();
            $assoc['user'] = $user;
        }
        return response()->json($data);
    }

    public function find($id)
    {
        $evenement = ReportProblem::find($id);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $user = User::select('login', 'avatar')
            ->join('user_utypes', 'user_utypes.type_id', '=', 'users.id')
            ->join('utypes', 'user_utypes.type_id', '=', 'utypes.id')
            ->where([
                    'utypes.id' => $evenement->utype_id, 
                    'user_utypes.is_active' => true
            ])->get();
            $evenement['user'] = $user;
        return response()->json($evenement);
    }

    public function findAllForUser(Request $req, $id)
    {
        $evenement = ReportProblem::wherePerson_id($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($evenement);
    }
}
