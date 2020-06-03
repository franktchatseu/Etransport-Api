<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use App\Models\Place\TypePoste;
use Illuminate\Http\Request;
use App\Models\Place\Poste;

class TypePosteController extends Controller
{
    /**
     * Display a listing of the resource.
     *by richie richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */

    public function index(Request $req)
    { {
            $data = TypePoste::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = TypePoste::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     *by richie richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = $request->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'name' => 'required|min:2',
            'description' => 'string|min:4'
        ]);

        $typePoste = new  TypePoste();
        $typePoste->description = $data['description'];
        $typePoste->name = $data['name'];

        $typePoste->save();

        return response()->json($typePoste);
    }

    /**
     * Update the specified resource in storage.
     *by richie richienebou@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place\TypePoste  $typePoste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $typePoste = TypePoste::find($id);
        if (!$typePoste) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TYPEPOSTE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->only([
            'name',
            'description'
        ]);

        $this->validate($data, [
            'description' => 'string|min:4',
            'name' => 'required|min:2'
        ]);

        if (null !== $data['name']) {
            $typePoste->name = $data['name'];
        }
        if (null !== $data['description']) {
            $typePoste->description = $data['description'];
        }


        $typePoste->update();

        return response()->json($typePoste);
    }

    /**
     * Remove the specified resource from storage.
     *by richie richienebou@gmail.com
     * @param  \App\Models\Place\TypePoste  $typePoste
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $typePoste = TypePoste::find($id);
        if (!$typePoste) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TYPEPOSTE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($typePoste);
    }





    public function findPostes(Request $req, $id)
    {

        $typePoste = TypePoste::find($id);
        if (!$typePoste) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TYPEPOSTE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        
        $postes = Poste::whereTypePosteId($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($postes);
    }




    public function destroy($id)
    {
      $typePoste = TypePoste::find($id);
        if (!$typePoste) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("TYPEPOSTE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $typePoste->delete();
        return response()->json();
    }
}
