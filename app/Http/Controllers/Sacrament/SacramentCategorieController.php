<?php

namespace App\Http\Controllers\Sacrament;

use App\Http\Controllers\Controller;
use App\Models\Sacrament\Sacrament;
use App\Models\Sacrament\SacramentCategorie;
use Illuminate\Http\Request;

class SacramentCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = SacramentCategorie::simplePaginate($req->has('limit') ? $req->limit : 15);
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
    public function store(Request $req)
    {
        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $category = new SacramentCategorie();
        $category->title = $data['title'];
        $category->description = $data['description'];
        $category->save();

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sacrament\SacramentCategorie  $sacramentCategorie
     * @return \Illuminate\Http\Response
     */
    public function show(SacramentCategorie $sacramentCategorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sacrament\SacramentCategorie  $sacramentCategorie
     * @return \Illuminate\Http\Response
     */
    public function edit(SacramentCategorie $sacramentCategorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sacrament\SacramentCategorie  $sacramentCategorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $category = SacramentCategorie::find($id);
        if (!$category) {
            abort(404, "No sacrament category found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required'
        ]);


        if ( $data['title']) $category->title = $data['title'];
        if ( $data['description']) $category->description = $data['description'];


        $category->update();

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sacrament\SacramentCategorie  $sacramentCategorie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$category = SacramentCategorie::find($id)) {
            abort(404, "No sacrament category found with id $id");
        }

        $category->delete();
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = SacramentCategorie::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$category = SacramentCategorie::find($id)) {
            abort(404, "No Sacrament category found with id $id");
        }
        return response()->json($category);
    }

    public function findSacrament(Request $req, $id)
    {
        if (!$sacrament = Sacrament::whereCategoryId($id)->simplePaginate($req->has('limit') ? $req->limit : 15)) {
            abort(404, "No sacrament for category with id $id found ");
        }
        return response()->json($sacrament);
    }
}
