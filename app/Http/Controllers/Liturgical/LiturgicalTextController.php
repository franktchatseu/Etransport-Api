<?php

namespace App\Http\Controllers\Liturgical;

use App\Http\Controllers\Controller;
use App\Models\Liturgical\LiturgicalText;
use Illuminate\Http\Request;

class LiturgicalTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = LiturgicalText::simplePaginate($req->has('limit') ? $req->limit : 15);
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
        $data = $req->except('files');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required',
            'image' => '',
            'type_entry_type_id' => 'required:exists:liturgical_type_entry_types,id'
         ]);
         
         $data['image'] = '';
         //upload image
         if ($file = $req->file('files')) {
             $filePaths = $this->saveMultipleImages($this, $req, 'files', 'liturgicals');
             $data['image'] = json_encode(['images' => $filePaths]);
         }
 
            $liturgicalText = new LiturgicalText();
            $liturgicalText->title = $data['title'];
            $liturgicalText->description = $data['description'];
            $liturgicalText->avatar = $data['avatar'];
            $liturgicalText->type_entry_type_id = $data['type_entry_type_id'];
            $liturgicalText->save();
       
        return response()->json($liturgicalText);
    }
                 

       
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liturgical\LiturgicalText  $liturgicalText
     * @return \Illuminate\Http\Response
     */
    public function show(LiturgicalText $liturgicalText)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liturgical\LiturgicalText  $liturgicalText
     * @return \Illuminate\Http\Response
     */
    public function edit(LiturgicalText $liturgicalText)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liturgical\LiturgicalText  $liturgicalText
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $liturgical = LiturgicalText::find($id);
        if (!$liturgical) {
            abort(404, "No liturgical type entry type found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required',
            'image' => '',
            'type_entry_type_id' => 'required:exists:liturgical_type_entry_types,id'
         ]);

         $data['image'] = '';
         //upload image
         if ($file = $req->file('files')) {
             $filePaths = $this->saveMultipleImages($this, $req, 'files', 'liturgicals');
             $data['image'] = json_encode(['images' => $filePaths]);
         }

        
         if ( $data['title']) $liturgical->title = $data['title'];
         if ( $data['description']) $liturgical->description = $data['description'];
         if (isset($data['avatar'])) $liturgical->avatar = $data['image'];
         if ( $data['entry_type_id']) $liturgical->entry_type_id = $data['type_entry_type_id'];

        
        $liturgical->update();

        return response()->json($liturgical);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liturgical\LiturgicalText  $liturgicalText
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$liturgical = LiturgicalText::find($id)) {
            abort(404, "No liturgical found with id $id");
        }

        $liturgical->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = LiturgicalText::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$liturgical = LiturgicalText::find($id)) {
            abort(404, "No liturgical found with id $id");
        }
        return response()->json($liturgical);
    }

    public function findLiturgicalText(Request $req, $slug)
    {
        $liturgical = LiturgicalText::select('liturgical_texts.*', 
                                            'liturgical_types.*',
                                            'entry_types.*',
                                            'liturgical_type_entry_types.*')
                                            ->where(['liturgical_types.slug' => $slug])
                                            ->join('liturgical_type_entry_types', 'liturgical_texts.type_entry_type_id', '=', 'liturgical_type_entry_types.id')
                                            ->join('liturgical_types', 'liturgical_type_entry_types.type_id', '=', 'liturgical_types.id')
                                             ->join('entry_types', 'liturgical_type_entry_types.entry_type_id', '=', 'entry_types.id')
                                            
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($liturgical);
    }

    public function findLiturgicalByType(Request $req, $id)
    {
        $liturgical = LiturgicalText::select('liturgical_texts.*', 
                                            'entry_types.*')
                                            ->where(['entry_types.id' => $id])
                                            ->join('liturgical_type_entry_types', 'liturgical_texts.type_entry_type_id', '=', 'liturgical_type_entry_types.id')
                                            ->join('liturgical_types', 'liturgical_type_entry_types.type_id', '=', 'liturgical_types.id')
                                             ->join('entry_types', 'liturgical_type_entry_types.entry_type_id', '=', 'entry_types.id')
                                            
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($liturgical);
    }
}