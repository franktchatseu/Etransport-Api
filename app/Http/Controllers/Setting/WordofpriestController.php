<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Wordofpriest;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Setting\Parish;

class WordofpriestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting\Wordofpriest  $wordofpriest
     * @return \Illuminate\Http\Response
     */
    public function edit(Wordofpriest $wordofpriest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting\Wordofpriest  $wordofpriest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wordofpriest $wordofpriest)
    {
        //
    }

    
    public function destroy(Wordofpriest $wordofpriest)
    {
        //
    }

    //recuperer le dernier mot du curre pour une paroisse donnne
    public function findWordPriest($id)
    {
        //
        $parish = Parish::find($id);
        
        //return response()->json($parish->name);
        if (!$parish) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISH_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        //on recupere le mot
        $wordofpriest = Wordofpriest::select('wordofpriests.*','parishs.picture_priest as picture_priest')
        ->join('parishs', ['parishs.id' => 'wordofpriests.parish_id'])
        ->orderBy('created_at','desc')
        ->where('parish_id','=',$id)->first();
        //on met addresse du serveur sur image
        if($wordofpriest)
            $wordofpriest->picture_priest=url($wordofpriest->picture_priest);
        return response()->json($wordofpriest);
    }
}
