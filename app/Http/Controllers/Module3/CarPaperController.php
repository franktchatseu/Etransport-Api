<?php

namespace App\Http\Controllers\Module3;


use App\Http\Controllers\Controller;
use App\Models\Module3\CarPaper;
use Illuminate\Http\Request;
use App\Models\APIError;

class CarPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //
        $data = CarPaper::simplePaginate($req->has('limit') ? $req->limit : 10);
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
        $data = $request->all();
        
        $this->validate($data, [
            'patent_validation' => 'required',
            'stepper_id' => 'required',
            'insurance_validation_date' => 'required',
            'technical_visit_date' => 'required'
        ]);

        $carpaper = new CarPaper();
        $carpaper->patent_validation = $data['patent_validation'];
        $carpaper->stepper_id = $data['stepper_id'];
        $carpaper->insurance_validation_date = $data['insurance_validation_date'];
        $carpaper->technical_visit_date = $data['technical_visit_date'];
        $carpaper->save();
       
        return response()->json($carpaper);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $carpaper = CarPaper::where('stepper_id',$id)->first();
        if (!$carpaper) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CAR_PAPER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        return response()->json($carpaper);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carpaper = CarPaper::where('stepper_id',$id)->first();
        if (!$carpaper) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CAR_PAPER_NOT_FOUND");

            return response()->json($apiError, 404);
        }

        $data = $request->all();
        
        if ( $request->patent_validation ?? null) $carpaper->patent_validation = $data['patent_validation'];
        if ( $request->insurance_validation_date ?? null) $carpaper->insurance_validation_date = $data['insurance_validation_date'];
        if ( $request->technical_visit_date ?? null) $carpaper->technical_visit_date = $data['technical_visit_date'];
        
        $carpaper->patent_validation = $data['patent_validation'];
        $carpaper->insurance_validation_date = $data['insurance_validation_date'];
        $carpaper->technical_visit_date = $data['technical_visit_date'];
        $carpaper->update();

        return response()->json($carpaper);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carpaper = CarPaper::find($id);
        if (!$carpaper) {

            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CAR_PAPER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $carpaper->delete();      
        return response()->json();
    }
}
