<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Catechesis;
use Illuminate\Http\Request;
use App\Models\APIError;

class CatechesisController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Catechesis::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'description' => 'required'
        ]);

            $catechesis = new Catechesis();
            $catechesis->name = $data['name'];
            $catechesis->description = $data['description'];
            $catechesis->save();
       
        return response()->json($catechesis);
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
        $catechesis = Catechesis::find($id);
        if (!$catechesis) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATECHESIS_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if (null !== $data['name']) $catechesis->name = $data['name'];
        if (null !== $data['description']) $catechesis->description = $data['description'];

        $catechesis->update();

        return response()->json($catechesis);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $catechesis = Catechesis::find($id);
        if (!$catechesis) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATECHESIS_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $catechesis->delete();      
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

        $data = Catechesis::where($req->field, 'like', "%$req->q%")
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
        $catechesis = Catechesis::find($id);
        if (!$catechesis) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATECHESIS_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($catechesis);
    }
}
