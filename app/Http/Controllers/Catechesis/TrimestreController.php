<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Trimestre;
use App\Models\Catechesis\Evaluation;
use Illuminate\Http\Request;
use App\Models\APIError;

class TrimestreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Trimestre::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Trimestre::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'begin_date' => 'required',
            'end_date' => 'required',
            'number'=> ''
        ]);

            $trimestre = new Trimestre();
            $trimestre->begin_date = $data['begin_date'];
            $trimestre->end_date = $data['end_date'];
            $trimestre->number = $data['number'];

            $trimestre->save();
       
        return response()->json($trimestre);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\Trimestre  $trimestre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $trimestre = Trimestre::find($id);
        if (! $trimestre) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TRIMESTRE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'begin_date' => 'required',
            'end_date' => 'required',
            'number'=>''
        ]);

        if (null !== $data['debut_date'])  $trimestre->begin_date = $data['begin_date'];
        if (null !== $data['end_date'])  $trimestre->end_date = $data['end_date'];
        if (null !== $data['number'])  $trimestre->number = $data['number'];

         $trimestre->update();

        return response()->json( $trimestre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catechesis\Trimestre  $trimestre
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trimestre = Trimestre::find($id);
        if (!$trimestre) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TRIMESTRE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $trimestre->delete();      
        return response()->json();
    }

    public function find($id)
    {
        $trimestre = Trimestre::find($id);
        if (!$trimestre) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TRIMESTRE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($trimestre);
    }

    public function findEvaluations(Request $req, $id)
    {
        $evaluation = Trimestre::find($id);
        if (!$evaluation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVALUATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $evaluations = Evaluation::whereTrimestresId($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($evaluations);
    }
}
