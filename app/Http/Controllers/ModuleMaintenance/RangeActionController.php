<?php

namespace App\Http\Controllers\ModuleMaintenance;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ModuleMaintenance\RangeAction;
use Illuminate\Http\Request;

class RangeActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rangeaction = RangeAction::latest()->paginate($request->has('limit') ? $request ->limit : 10);

        return $rangeaction;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rangeaction = RangeAction::create($request->all());

        return response()->json($rangeaction, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rangeaction = RangeAction::findOrFail($id);

        return $rangeaction;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $rangeaction = RangeAction::findOrFail($id);
        $rangeaction->update($request->all());

        return response()->json($rangeaction, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RangeAction::destroy($id);

        return response()->json(null, 204);
    }
}
