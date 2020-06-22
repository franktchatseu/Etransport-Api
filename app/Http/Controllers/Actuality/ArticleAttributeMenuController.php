<?php

namespace App\Http\Controllers\Actuality;

use App\Models\APIError;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actuality\Article_Attribute_Menu;
use App\Models\Actuality\Attribute_Menu;
use App\Models\Actuality\Article;

class Article_Attribute_MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Article_Attribute_Menu::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'article_id' => 'required',
            'attribute_menu_id' => 'required',
            'value' => 'required',
        ]);
       
        if(Article::find($request->article_id) == null)
        {
            $apiError = new APIError;
            $apiError->setStatus("400");
            $apiError->setCode("ARTICLE_ID_NOT_FOUND");
            $apiError->setErrors(['article_id' => 'article_id not existing']);

            return response()->json($apiError, 400);
        }

        if(Attribute_Menu::find($request->attribute_menu_id) == null)
        {
            $apiError = new APIError;
            $apiError->setStatus("400");
            $apiError->setCode("ATTRIBUTE_ID_NOT_FOUND");
            $apiError->setErrors(['attribute_menu_id' => 'attribute_menu_id not existing']);

            return response()->json($apiError, 400);
        }

            $article_attribute_menu = new Article_Attribute_Menu();
            $article_attribute_menu->article_id = $request->article_id;
            $article_attribute_menu->attribute_menu_id = $request->attribute_menu_id;
            $article_attribute_menu->value = $request->value;
            
            $article_attribute_menu->save();
       
        return response()->json($article_attribute_menu);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actuality\article_attribute_menu  $article_attribute_menu
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $article_attribute_menu = Article_Attribute_Menu::find($id);
        if (!$article_attribute_menu = Article_Attribute_Menu::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ARTICLE_ATTRIBUTE_MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return $article_attribute_menu;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\Article_Attribute_Menu  $article_attribute_menu
     * @return \Illuminate\Http\Response
     */
    public function edit(article_attribute_menu $article_attribute_menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Article_Attribute_Menu  $article_attribute_menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article_attribute_menu = Article_Attribute_Menu::find($id);
        if (!$article_attribute_menu) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ARTICLE_ATTRIBUTE_MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->except('photo');

        $this->validate($data, [
        ]);

        if(Article::find($request->article_id) == null)
        {
            $apiError = new APIError;
            $apiError->setStatus("400");
            $apiError->setCode("ARTICLE_ID_NOT_FOUND");
            $apiError->setErrors(['article_id' => 'article_id not existing']);

            return response()->json($apiError, 400);
        }


        if(Attribute_Menu::find($request->attribute_menu_id) == null)
        {
            $apiError = new APIError;
            $apiError->setStatus("400");
            $apiError->setCode("ATTRIBUTE_ID_NOT_FOUND");
            $apiError->setErrors(['attribute_menu_id' => 'attribute_menu_id not existing']);

            return response()->json($apiError, 400);
        }

        $article_attribute_menu = new Article_Attribute_Menu();
        if( $request->article_id) $article_attribute_menu->article_id = $request->article_id;
        if($request->attribute_menu_id) $article_attribute_menu->attribute_menu_id = $request->attribute_menu_id;
        if($request->value) $article_attribute_menu->value = $request->value;
        $article_attribute_menu->update();

        return response()->json($article_attribute_menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\article_attribute_menu  $article_attribute_menu
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Article_Attribute_Menu::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function destroy($id)
    {
        if (!$article_attribute_menu = Article_Attribute_Menu::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ARTICLE_ATTRIBUTE_MENU_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $article_attribute_menu->delete();      
        return response()->json(202);
    }

    public function findArticleMenu(Request $req, $id)
    {
        $sacrament = Article_Attribute_Menu::select('article_attribute_menu.*', 'article_attribute_menu.id as usacrament_id', 'sacraments.*', 'sacraments.id as id_sacrament')
        ->join('sacraments', 'user_sacraments.sacrament_id', '=', 'sacraments.id')
        ->where(['user_sacraments.user_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($sacrament);
    }
    
}

