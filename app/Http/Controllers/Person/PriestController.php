<?php

namespace App\Http\Controllers\person;

use App\Http\Controllers\Controller;
use App\Models\person\Priest;
use Illuminate\Http\Request;

class PriestController extends Controller
{
    /**
     * Display a list of person from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Priest::simplePaginate($req->has('limit') ? $req->limit : 15);
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
     * Create a person on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'ordination_date' => 'required',
            'ordination_place' => 'required',
            'ordination_godfather' => 'required',
            'career' => 'required',
            'user_utype_id' => 'required:exists:user_utypes,id'
        ]);

            $priest = new Priest();
            $priest->ordination_date = $data['ordination_date'];
            $priest->ordination_place = $data['ordination_place'];
            $priest->ordination_godfather = $data['ordination_godfather'];
            $priest->career = $data['career'];
            $priest->user_utype_id = $data['user_utype_id'];
            $priest->save();
       
        return response()->json($priest);
    }

 

    
    /**
     * Update a person on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $priest = Priest::find($id);
        if (!$priest) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PRIEST_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'ordination_date' => 'required',
            'ordination_place' => 'required',
            'ordination_godfather' => 'required',
            'career' => 'required',
        ]);

        if ( $data['ordination_date']) $priest->ordination_date = $data['ordination_date'];
        if ( $data['ordination_place']) $priest->ordination_place = $data['ordination_place'];
        if ( $data['ordination_godfather']) $priest->ordination_godfather = $data['ordination_godfather'];
        if ( $data['career']) $priest->career = $data['career'];
        
        $priest->update();

        return response()->json($priest);
    }

    /**
     * Remove a person from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$priest = Priest::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PRIEST_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $priest->delete();      
        return response()->json();
    }

    /**
     * Search a person from database
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

        $data = Priest::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Find a person from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        if (!$priest = Priest::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PRIEST_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($priest);
    }
}
