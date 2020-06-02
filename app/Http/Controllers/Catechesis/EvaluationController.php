<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Evaluation::simplePaginate($req->has('limit') ? $req->limit : 15);
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
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'evaluation_type' => 'required',
            'note' => 'required'
        ]);

            $evaluation = new Evaluation();
            $evaluation->evaluation_type = $data['evaluation_type'];
            $evaluation->note = $data['note'];
            $evaluation->save();
       
        return response()->json($evaluation);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluation $evaluation)
    {
        //
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluation $evaluation)
    {
        //
    }

    
   /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $evaluation = Evaluation::find($id);
        if (!$evaluation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVALUATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'evaluation_type' => 'required',
            'note' => 'required'
        ]);

        if (null !== $data['evaluation_type']) $evaluation->evaluation_type = $data['evaluation_type'];
        if (null !== $data['note']) $evaluation->note = $data['note'];
        
        $evaluation->update();

        return response()->json($evaluation);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evaluation = Evaluation::find($id);
        if (!$evaluation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVALUATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $evaluation->delete();      
        return response()->json();
    }
/**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Evaluation::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $evaluation = Evaluation::find($id);
        if (!$evaluation) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVALUATION_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($evaluation);
    }
}
