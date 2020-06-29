<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Person\Cathechumene;
use Illuminate\Http\Request;

class CathechumeneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Cathechumene::simplePaginate($req->has('limit')? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
         $data = $req->except('birth_certificate');

        $this->validate($data, [
            'father_tel' => 'required',
            'godfather_tel' => 'required',
            // 'profession_id' => 'required',
            'catechese_level' => 'required',
            'catechese_place' => 'required',
        ]);

        $cathechumene = new Cathechumene();
        $cathechumene->father_tel = $data['father_tel'];
        $cathechumene->godfather_tel = $data['godfather_tel'];
        // $cathechumene->profession_id = $data['profession_id'];
        $cathechumene->catechese_level = $data['catechese_level'];
        $cathechumene->catechese_place = $data['catechese_place'];
        $cathechumene->birth_certificate = $data['birth_certificate'];  
        $cathechumene->save();
       
        return response()->json($cathechumene);
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

    public function search(Request $req)
    {
        $this->validate($req->all(), ['q'=>'present',
        'field'=>'present'
       ]);
       $data = Cathechumene::where($req->field,'like',"%$req->q%")->get();
       return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\Cathechumene  $cathechumene
     * @return \Illuminate\Http\Response
     */
    public function show(Cathechumene $cathechumene)
    {
        //
    }
    public function find($id)
    {
        if(!$cathechumene = Cathechumene::find($id)){    
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATHECHUMENE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($cathechumene);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\Cathechumene  $cathechumene
     * @return \Illuminate\Http\Response
     */
    public function edit(Cathechumene $cathechumene)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Cathechumene  $cathechumene
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req , $id)
    {
        
    
        $cathechumene = Cathechumene::find($id);
        if (!$cathechumene) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATHECHUMENE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('birth_certificate');

        $this->validate($data, [
            'father_tel' => 'required',
            'godfather_tel' => 'required',
            'profession_id' => 'required',
            'catechese_level' => 'required',
            'catechese_place' => 'required',
        ]);

        //upload image
        $filePaths = $this->saveMultipleImages($this, $req, 'birth_certificate', 'cathechumenes');
        $data['birth_certificate'] = json_encode(['images' => $filePaths]);

        if ( $data['father_tel']) $cathechumene->father_tel = $data['father_tel'];
        if ( $data['godfather_tel']) $cathechumene->godfather_tel = $data['godfather_tel'];
        // if ( $data['profession_id']) $cathechumene->profession_id = $data['profession_id'];
        if ( $data['catechese_level']) $cathechumene->catechese_level = $data['catechese_level'];
        if ( $data['catechese_place']) $cathechumene->catechese_place = $data['catechese_place'];
    
        
        
        $cathechumene->update();

        return response()->json($cathechumene);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\Cathechumene  $cathechumene
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$cathechumene = Cathechumene::find($id)){            
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("CATHECHUMENE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $cathechumene->delete();
        return response()->json();
    }
}
