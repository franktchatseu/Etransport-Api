<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Parish_theme;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Setting\Parish;

class Parish_themeController extends Controller
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
     * Display the specified resource.
     *
     * @param  \App\Models\Setting\Parish_theme  $parish_theme
     * @return \Illuminate\Http\Response
     */
    public function show(Parish_theme $parish_theme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting\Parish_theme  $parish_theme
     * @return \Illuminate\Http\Response
     */
    public function edit(Parish_theme $parish_theme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting\Parish_theme  $parish_theme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parish_theme $parish_theme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting\Parish_theme  $parish_theme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parish_theme $parish_theme)
    {
        //
    }
    //recuperer le theme paroissiale recent de la paroisse
    public function findParishTheme($id)
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
        $parish_theme = Parish_theme::select('parish_themes.*')
        ->orderBy('created_at','desc')
        ->where('parish_id','=',$id)->first();
        //on met addresse du serveur sur image
        $parish_theme->image=url($parish_theme->image);
        return response()->json($parish_theme);
    }
}
