<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Tarif;
use Illuminate\Http\Request;
use App\Models\APIError;

class TarifController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Tarif::simplePaginate($req->has('limit') ? $req->limit : 15);
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
        $data = $req->only([
            'name',
            'description',
            'price'
        ]);

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
         ]);

        $tarif = new Tarif();
        $tarif->name = $data['name'];
        $tarif->description = $data['description'];
        $tarif->price = $data['price'];
        $tarif->save();
       
        return response()->json($tarif);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finance\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $tarif = Tarif::find($id);
        if($tarif == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("TARIF_NOT_FOUND");
            $notFound->setMessage("tarif with id " . $id . " not found");

            return response()->json($notFound, 404);
        }
        return response()->json($tarif);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);
        $data= Tarif::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finance\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $tarif = Tarif::find($id);
        if($tarif == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("TARIF_NOT_FOUND");
            $notFound->setMessage("tarif with id " . $id . " not found");

            return response()->json($notFound, 404);
        }

        $data = $req->only([
            'name',
            'description',
            'price'
        ]);

        $this->validate($data, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
         ]);

        
        if (null !== $data['name']) $tarif->name = $data['name'];
        if (null !== $data['description']) $tarif->description = $data['description'];
        if (null !== $data['price']) $tarif->price = $data['price'];
         
        $tarif->update();

        return response()->json($tarif);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance\Tarif  $tarif
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarif = Tarif::find($id);
        if($tarif == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("TARIF_NOT_FOUND");
            $notFound->setMessage("tarif with id " . $id . " not found");

            return response()->json($notFound, 404);
        }

        $tarif->delete();      
        return response()->json();
    }

}      
