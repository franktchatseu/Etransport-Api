<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Plug;
use Illuminate\Http\Request;

class PlugController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Plug::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
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
            'name' => 'required',
            'date' => 'required',
            'pattern_id' => 'required'
        ]);

            $plug = new Plug();
            $plug->name = $data['name'];
            $plug->date = $data['date'];
            $plug->pattern_id = $data['pattern_id'];
            $plug->save();
       
        return response()->json($plug);
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
        $plug = Plug::find($id);
        if (!$plug) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Plug_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'date' => 'required',
            'pattern_id' => 'required'
        ]);

        if ( $data['name']) $plug->name = $data['name'];
        if ( $data['date']) $plug->date = $data['date'];
        if ( $data['pattern_id']) $plug->pattern_id = $data['pattern_id'];
        
        $plug->update();

        return response()->json($plug);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plug = Plug::find($id);
        if (!$plug) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Plug_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $plug->delete();      
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

        $data = Plug::where($req->field, 'like', "%$req->q%")
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
        $plug = Plug::find($id);
        if (!$plug) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("Plug_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($plug);
    }
}
