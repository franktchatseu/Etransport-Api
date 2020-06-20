<?php

namespace App\Http\Controllers\Actuality;

use App\Models\APIError;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actuality\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Menu::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'logo' => '',
        ]);

        $data['logo'] = '';
        //upload image
        if ($file = $request->file('logo')) {
            $filePaths = $this->saveSingleImage($this, $request, 'logo', 'menus');
            $data['logo'] = json_encode(['images' => $filePaths]);
        }


            $menus = new Menu();
            $menus->name = $request->name;
            $menus->logo = $data['logo'];
            $menus->description = $request->description;
            
            $menus->save();
       
        return response()->json($menus);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\menu  $menus
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $menus = Menu::find($id);
        if (!$menus = Menu::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return $menus;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\Menu  $menus
     * @return \Illuminate\Http\Response
     */
    public function edit(menus $menus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Menu  $menus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->except('photo');

        $this->validate($request->all(), [
            'name' => 'required',
            'logo' => '',
        ]);
        
         
        //upload image
        if ($file = $request->file('logo')) {
            $filePaths = $this->saveSingleImage($this, $request, 'logo', 'menus');
            $data['logo'] = json_encode(['images' => $filePaths]);
        }


        if ( $data['name']) $menu->name = $data['name'];
        if ( $data['logo']) $menu->logo = $data['logo'];
        if ( $data['description']) $menu->description = $data['description'];
        
        $menu->update();

        return response()->json($menu);
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\menus  $menus
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Menu::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function destroy($id)
    {
        if (!$menu = Menu::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $menu->delete();      
        return response()->json();
    }

    
}

