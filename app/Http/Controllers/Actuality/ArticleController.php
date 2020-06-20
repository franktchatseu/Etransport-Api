<?php

namespace App\Http\Controllers\Actuality;

use App\Models\APIError;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actuality\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Article::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'user_id' => 'required',
            'sub_menu_id' => 'required',
            
        ]);

            $article = new Article();
            $article->user_id = 'user_id';
            $article->sub_menu_id = 'sub_menu_id';
            
            $article->save();
       
        return response()->json($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person\article  $article
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $article = Article::find($id);
        if (!$article = Article::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ARTICLE_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $article = Article::find($id);
        if (!$article) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ARTICLE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'user_id' => 'required|min:2',
            'sub_menu_id' => 'required|min:2',
            
        ]);

        $article->update();

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\article  $article
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Article::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function destroy($id)
    {
        if (!$article = Article::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ARTICLE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $article->delete();      
        return response()->json(202);
    }

    
}

