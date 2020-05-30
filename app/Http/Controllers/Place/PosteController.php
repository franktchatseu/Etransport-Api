<?php

namespace App\Http\Controllers\Place;

use App\Http\Controllers\Controller;
use App\Models\Place\Poste;
use Illuminate\Http\Request;

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
            'type_poste_id'=>'integer|required'
        ]);

        $poste=new  Poste();
        $poste->place=$data['place'];
        $poste->name=$data['name'];
        $poste->type_poste_id=$data['type_poste_id'];

        $poste->save();

        return response()->json($poste);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place\Poste  $poste
     * @return \Illuminate\Http\Response
     */
    public function show(Poste $poste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place\Poste  $poste
     * @return \Illuminate\Http\Response
     */
    public function edit(Poste $poste)
    {
        //
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
            abort(404, "No poste found with id $id");
        }

        $data = $request->only([
            'name',
            'place',
            'type_poste_id'
        ]);

        $this->validate($data, [
            'place' => 'string|min:2',
            'name' => 'required',
            'type_poste_id'=>'integer|required'
        ]);

       if (null!==$data['name']){
        $poste->name=$data['name'];
       }
       if (null!==$data['place']){
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
            if (!$poste = Poste::find($id)) {
                abort(404, "No poste found with id $id");
            }
            return response()->json($poste);
        }
    
        public function destroy($id)
        {
            if (!$poste = Poste::find($id)) {
                abort(404, "No poste found with id $id");
            }
    
            $poste->delete();      
            return response()->json();
        }

}
