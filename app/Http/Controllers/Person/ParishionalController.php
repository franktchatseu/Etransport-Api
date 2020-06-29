<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Person\Parishional;
use Illuminate\Http\Request;
use App\Models\APIError;

class ParishionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Parishional::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
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
            'quarter' => 'required',
            'isBaptist' => 'required',
            'user_utype_id' => 'required:exists:user_utypes,id'
         ]);


            $parishional = new Parishional();
            $parishional->quarter = $data['quarter'];
            $parishional->isBaptist = $data['isBaptist'];
            $parishional->user_utype_id = $data['user_utype_id'];
            $parishional->save();
       
        return response()->json($parishional);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Parishional  $parishional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        if (!$parishional = Parishional::find($id)){
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHIONAL_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'quarter' => 'required',
            'isBaptist' => 'required'
         ]);

        
        if ( $data['quarter']) $parishional->quarter = $data['quarter'];
        if ( $data['isBaptist']) $parishional->isBaptist = $data['isBaptist'];
        
        $parishional->update();

        return response()->json($parishional);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\Parishional  $parishional
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$parishional = Parishional::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHIONAL_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $parishional->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Parishional::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$parishional =Parishional::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHIONAL_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($parishional);
    }


}
