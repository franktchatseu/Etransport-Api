<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use App\Models\Place\Poste;
use Illuminate\Http\Request;
use App\Models\APIError;

class PosteController extends Controller
{
     /**
     * Display a listing of the resource.
     *by richie:richie richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        {
            $data = Poste::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'        
        ]);

        $data = Poste::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for creating a new resource.
     **by richie:richie richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = $request->only([
            'name',
            'place',
            'type_poste_id'
        ]);

        $this->validate($data, [
            'place' => 'string|min:2',
            'name' => 'required',
            'type_poste_id'=>'required:exists:type_postes,id'
        ]);

        $poste=new  Poste();
        $poste->place=$data['place'];
        $poste->name=$data['name'];
        $poste->type_poste_id=$data['type_poste_id'];

        $poste->save();

        return response()->json($poste);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place\Poste  $poste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $poste = Poste::find($id);
        if (!$poste) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("POSTE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->only([
            'name',
            'place',
            'type_poste_id'
        ]);

        $this->validate($data, [
            'place' => 'string|min:2',
            'name' => 'required',
            'type_poste_id'=>'required:exists:type_postes,id'
        ]);

       if (null!==$data['name'] ?? null){
        $poste->name=$data['name'];
       }
       if (null!==$data['place'] ?? null){
        $poste->place=$data['place'];
       }
       

       $poste->update();

       return response()->json($poste);

    }

    /**
     * Remove the specified resource from storage.
     **by richie:richie richienebou@gmail.com
     
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $poste = Poste::find($id);
        if (!$poste) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("POSTE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            return response()->json($poste);
        }
    
        public function destroy($id)
        {
            $poste = Poste::find($id);
            if (!$poste) {
                $apiError = new APIError;
                $apiError->setStatus("404");
                $apiError->setCode("POSTE_NOT_FOUND");
                return response()->json($apiError, 404);
            }
    
            $poste->delete();      
            return response()->json();
        }

}
