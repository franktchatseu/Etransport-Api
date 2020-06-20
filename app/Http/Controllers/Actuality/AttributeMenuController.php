<?php

namespace App\Http\Controllers\Actuality;

use App\Models\APIError;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actuality\Attribute_Menu;

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
            'name' => 'required',
            'description' => 'required',
        ]);

            $Attribute_Menu = new Attribute_Menu();
            $Attribute_Menu->attribute_id = 'attribute_id';
            $Attribute_Menu->sub_menu_id = 'sub_menu_id';            
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
    public function update(Request $req, $id)
    {
        $Attribute_Menu = Attribute_Menu::find($id);
        if (!$Attribute_Menu) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ATTRIBUTE_MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'attribute_id' => 'required|min:2',
            'sub_menu_id' => 'required|min:2',
            
        ]);

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
