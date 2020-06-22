<?php

namespace App\Http\Controllers\Actuality;

use App\Models\APIError;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actuality\Attribute_Menu;
use App\Models\Actuality\Menu;
use App\Models\Actuality\Attribute;

class Attribute_MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Attribute_Menu::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
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
        

        $this->validate($request->all(), [
            'attribute_id' => 'required',
            'menu_id' => 'required',
        ]);

        if(Menu::find($request->menu_id) == null)
        {
            $apiError = new APIError;
            $apiError->setStatus("400");
            $apiError->setCode("MENU_ID_NOT_FOUND");
            $apiError->setErrors(['menu_id' => 'menu_id not existing']);

            return response()->json($apiError, 400);
        }

        if(Attribute::find($request->attribute_id) == null)
        {
            $apiError = new APIError;
            $apiError->setStatus("400");
            $apiError->setCode("ATTRIBUTE_ID_NOT_FOUND");
            $apiError->setErrors(['attribute_id' => 'attribute_id not existing']);

            return response()->json($apiError, 400);
        }
        

            $Attribute_Menu = new Attribute_Menu();
            $Attribute_Menu->attribute_id = $request->attribute_id;
            $Attribute_Menu->menu_id = $request->menu_id;  
            if($request->is_required) $Attribute_Menu->is_required;
            if($request->max_length) $Attribute_Menu->max_length;
            if($request->min_length) $Attribute_Menu->min_length;

            $Attribute_Menu->save();

        return response()->json($Attribute_Menu);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\Attribute_Menu  $Attribute_Menu
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $Attribute_Menu = Attribute_Menu::find($id);
        if (!$Attribute_Menu = Attribute_Menu::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ATTRIBUTE_MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return $Attribute_Menu;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\Attribute_Menu  $Attribute_Menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute_Menu $Attribute_Menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Attribute_Menu  $Attribute_Menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Attribute_Menu = Attribute_Menu::find($id);
        if (!$Attribute_Menu) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ATTRIBUTE_MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->except('photo');

        $this->validate($request->all(), [
            
        ]);

        if(Menu::find($request->menu_id) == null)
        {
            $apiError = new APIError;
            $apiError->setStatus("400");
            $apiError->setCode("MENU_ID_NOT_FOUND");
            $apiError->setErrors(['menu_id' => 'menu_id not existing']);

            return response()->json($apiError, 400);
        }

        if(Attribute::find($request->attribute_id) == null)
        {
            $apiError = new APIError;
            $apiError->setStatus("400");
            $apiError->setCode("ATTRIBUTE_ID_NOT_FOUND");
            $apiError->setErrors(['attribute_id' => 'attribute_id not existing']);

            return response()->json($apiError, 400);
        }


            $Attribute_Menu = new Attribute_Menu();
            if($request->atributes_id) $Attribute_Menu->attribute_id = $request->attribute_id;
            if($request->menu_id) $Attribute_Menu->menu_id = $request->menu_id;  
            if($request->is_required) $Attribute_Menu->is_required;
            if($request->max_length) $Attribute_Menu->max_length;
            if($request->min_length) $Attribute_Menu->min_length;


        $Attribute_Menu->update();

        return response()->json($Attribute_Menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\Attribute_Menu  $Attribute_Menu
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Attribute_Menu::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function destroy($id)
    {
        if (!$Attribute_Menu = Attribute_Menu::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ATTRIBUTE_MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $Attribute_Menu->delete();      
        return response()->json();
    }

    
}
