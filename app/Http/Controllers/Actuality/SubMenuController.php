<?php

namespace App\Http\Controllers\Actuality;

use App\Models\APIError;
use App\Http\Controllers\Controller;
use App\Models\Actuality\Menu;
use Illuminate\Http\Request;
use App\Models\Actuality\Sub_Menu;
use Illuminate\Support\Str;

class SubMenuController extends Controller
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
            'name' => 'required|unique:sub_menus',
            'menu_id'=> 'required',
        ]);
        
        if(Menu::find($request->menu_id) == null)
        {
            $apiError = new APIError;
            $apiError->setStatus("400");
            $apiError->setCode("MENU_ID_NOT_FOUND");
            $apiError->setErrors(['menu_id' => 'menu_id not existing']);

            return response()->json($apiError, 400);
        }

        $sub_Menu = new Sub_Menu();
        $data['logo'] = '';
        //upload image
        if ($file = $request->file('logo')) {
            $filePaths = $this->saveSingleImage($this, $request, 'logo', 'sub_menus');
            $sub_Menu->logo = $data['logo'] = json_encode(['images' => $filePaths]);
        }   

        
        $sub_Menu->name = $request->name;
        $sub_Menu->menu_id = $request->menu_id;
        $sub_Menu->slug = Str::slug($request->name) . time();
        if( $request->description) $sub_Menu->description = $request->description;
        
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
    public function update(Request $request, $id)
    {
        $submenu = Sub_Menu::find($id);
        if (!$submenu) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("SUB_MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->except('photo');

        $this->validate($request->all(), [
            'name' => 'required|unique:sub_menus',
            'menu_id'=> 'required',
        ]);
        
         
        //upload image
        if ($file = $request->file('logo')) {
            $filePaths = $this->saveSingleImage($this, $request, 'logo', 'menus');
            $data['logo'] = json_encode(['images' => $filePaths]);
            $submenu->logo = $data['logo'];
        }

        if ( $request->name) $submenu->name = $data['name'];
        if ( $request->menu_id) $submenu->menu_id = $data['menu_id'];
        if ( $request->description) $submenu->description = $data['description'];
        
        $submenu->update();

        return response()->json($submenu);
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
            $apiError->setCode("SUB_MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $sub_menu->delete();      
        return response()->json();
    }

    public function findSubMenu(Request $req, $slug)
    {
        if ($slug) {
                if(!$menus = Menu::whereSlug($slug)->first()){ 
                    $apiError = new APIError;
                    $apiError->setStatus("404");
                    $apiError->setCode("NAME_OF_MENU_NOT_FOUND");
                    return response()->json($apiError, 404);   
                }
                
                $submenu = Sub_Menu::whereMenuId($menus->id)->simplePaginate($req->has('limit') ? $req->limit : 15);
            }

        return response()->json($submenu);
        
    }
  
}
