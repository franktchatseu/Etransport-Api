<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\QuarterTrimestre;
use Illuminate\Http\Request;
use App\Models\APIError;

class QuarterTrimestreController extends Controller
{
    public function index(Request $req)
    {
        $data = QuarterTrimestre::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'quarter_id' => 'required:exists:quarters,id',
            'trimestre_id' => 'required:exists:trimestres,id'
         ]);


            $quarter_Trimestre = new QuarterTrimestre();
            $quarter_Trimestre->quarter_id = $data['quarter_id'];
            $quarter_Trimestre->trimestre_id = $data['trimestre_id'];
            $quarter_Trimestre->save();
       
        return response()->json($quarter_Trimestre);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\quarterTrimestre  $quarter_Trimestre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $quarter_Trimestre = QuarterTrimestre::find($id);
        if (!$quarter_Trimestre) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("QUARTER_TRIMESTRE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'quarter_id' => 'required:exists:quarters,id',
            'trimestre_id' => 'required:exists:trimestres,id'
         ]);

        
        if ( $data['quarter_id']) $quarter_Trimestre->quarter_id= $data['quarter_id'];
        if ( $data['trimestre_id']) $quarter_Trimestre->trimestre_id = $data['trimestre_id'];

        $quarter_Trimestre->update();
        return response()->json($quarter_Trimestre);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catechesis\quarterTrimestre  $quarter_Trimestre
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quarter_Trimestre = QuarterTrimestre::find($id);
        if (!$quarter_Trimestre) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("QUARTER_TRIMESTRE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $quarter_Trimestre->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = QuarterTrimestre::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        $quarter_Trimestre = QuarterTrimestre::find($id);
        if (!$quarter_Trimestre) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("QUARTER_TRIMESTRE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($quarter_Trimestre);
    }

    public function findQuarterTrimestres(Request $req, $id)
    {
        $quarter_Trimestres = QuarterTrimestre::select('quarter_trimestres.*', 'quarter_trimestres.id as quartertrimestre_id', 'trimestres.*', 'trimestres.id as id_trimestre')
        ->join('trimestres', 'quarter_trimestres.trimestre_id', '=', 'trimestres.id')
        ->where(['quarter_trimestres.quarter_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($quarter_Trimestres);
    }
    
 

}
