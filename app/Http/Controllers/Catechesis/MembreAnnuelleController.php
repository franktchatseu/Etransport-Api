<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\MembreAnnuelle;
use Illuminate\Http\Request;

class MembreAnnuelleController extends Controller
{
    /**
     * Display a listing of the resource.
     *by richie:richie richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        {
            $data = MembreAnnuelle::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'        
        ]);

        $data = MembreAnnuelle::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }


    /**
     * Show the form for creating a new resource.
     **by richie:richie richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = $request->only([
            'class',
            'is_admin'
        ]);

        $this->validate($data, [
            'class' => 'required|string|min:2',
            'is_admin' => 'required'
        ]);

        $membreAnnuelle=new  MembreAnnuelle();
        $membreAnnuelle->class=$data['class'];
        $membreAnnuelle->is_admin=$data['is_admin'];

        $membreAnnuelle->save();

        return response()->json($membreAnnuelle);
    }

    /**
     * Store a newly created resource in storage.
     **by richie:richie richienebou@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     **by richie:richie richienebou@gmail.com
     * @param  \App\Models\Catechesis\MembreAnnuelle  $membreAnnuelle
     * @return \Illuminate\Http\Response
     */
    public function show(MembreAnnuelle $membreAnnuelle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     **by richie:richie richienebou@gmail.com
     * @param  \App\Models\Catechesis\MembreAnnuelle  $membreAnnuelle
     * @return \Illuminate\Http\Response
     */
    public function edit(MembreAnnuelle $membreAnnuelle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     **by richie:richie richienebou@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\MembreAnnuelle  $membreAnnuelle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $membreAnnuelle = MembreAnnuelle::find($id);
        if (!$membreAnnuelle) {
            abort(404, "No membreAnnuelle found with id $id");
        }

        $data = $request->only([
            'context',
            'is_admin'
        ]);

        $this->validate($data, [
            'class' => '',
            'is_admin' => 'required'
        ]);

       if (null!==$data['class']){
        $membreAnnuelle->class=$data['class'];
       }
       if (null!==$data['is_admin']){
        $membreAnnuelle->is_admin=$data['is_admin'];
       }
       

       $membreAnnuelle->update();

       return response()->json($membreAnnuelle);

    }


    /**
     * Remove the specified resource from storage.
     **by richie:richie richienebou@gmail.com
     * @param  \App\Models\Catechesis\MembreAnnuelle  $membreAnnuelle
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
            if (!$membreAnnuelle = MembreAnnuelle::find($id)) {
                abort(404, "No membreAnnuelle found with id $id");
            }
            return response()->json($membreAnnuelle);
        }
    
        public function destroy($id)
        {
            if (!$membreAnnuelle = MembreAnnuelle::find($id)) {
                abort(404, "No membreAnnuelle found with id $id");
            }
    
            $membreAnnuelle->delete();      
            return response()->json();
        }
}


