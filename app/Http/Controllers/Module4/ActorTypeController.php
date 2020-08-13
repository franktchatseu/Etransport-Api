<?php

namespace App\Http\Controllers\Module4;

use App\Http\Controllers\Controller;
use App\Models\Module4\ActorType;
use Illuminate\Http\Request;
use App\Models\APIError;

class ActorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $actortype = ActorType::simplePaginate($request->has('limit') ? $request ->limit : 10);
        return response()->json($actortype);
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
         $data = $request->all();
         $this->validate($data, [
             'name' => 'required',
             'description' => 'required',
         ]);
       
         $actorType = new ActorType();
         $actorType->name = $data['name'];
         $actorType->description = $data['description'];
         $actorType->save();
    
         return response()->json($actorType);
    }


    public function find($id)
    {
        $actorType = ActorType::find($id);
        if (!$actorType) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ActorType");
            return response()->json($apiError, 404);
        }
            return response()->json($actorType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module4\ActorType  $actorType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
         $actorType = ActorType::find($id);
         if (!$actorType) {
             $apiError = new APIError;
             $apiError->setStatus("404");
             $apiError->setCode("ActorType_NOT_FOUND");
             return response()->json($apiError, 404);
         }
 
         $data = $request->all();
         if ( $data['name']) $actorType->name = $data['name'];
         if ( $data['description']) $actorType->description = $data['description'];

         $actorType->update();
 
         return response()->json($actorType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module4\ActorType  $actorType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $actorType = ActorType::find($id);
        if (!$actorType) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ACTORTYPE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            $actorType->delete();      
            return response()->json();
    }
}
