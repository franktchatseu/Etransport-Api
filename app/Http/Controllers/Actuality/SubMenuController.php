<?php

namespace App\Http\Controllers\Actuality;

use App\Models\APIError;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actuality\Sub_Menu;

class Sub_MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Sub_Menu::simplePaginate($req->has('limit') ? $req->limit : 15);
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

            $sub_Menu = new Sub_Menu();
            $sub_Menu->name = 'name';
            $sub_Menu->description = 'description';
            
            $sub_Menu->save();
       
        return response()->json($sub_Menu);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\sub_menu  $sub_Menu
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $sub_Menu = Sub_Menu::find($id);
        if (!$sub_Menu = Sub_Menu::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SOUS_MENU_NOT_FOUNT");
            return response()->json($apiError, 404);
        }
        return $sub_Menu;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\Sub_Menu  $sub_Menu
     * @return \Illuminate\Http\Response
     */
    public function edit(sub_Menu $sub_Menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Sub_Menu  $sub_Menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $sub_menu = Sub_Menu::find($id);
        if (!$sub_menu) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SOUS_MENU_NOT_FOUNT");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            
        ]);

        $sub_menu->update();

        return response()->json($sub_menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\sub_Menu  $sub_Menu
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Sub_Menu::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function destroy($id)
    {
        if (!$sub_menu = Sub_Menu::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SOUS_MENU_NOT_FOUNT");
            return response()->json($apiError, 404);
        }

        $sub_menu->delete();      
        return response()->json();
    }

    
}
