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
            'contenu' => 'required',
            'image' => '',
            'type_entry_type_id' => 'required:exists:liturgical_type_entry_types,id',
            'parish_id' => 'required:exists:liturgical_type_entry_types,id'
         ]);
         
         if(isset($req->image)){
            $file = $req->file('image');
            $path = null;
            if($file != null){
             $extension = $file->getClientOriginalExtension();
             $relativeDestination = "uploads/liturgicals/image";
             $destinationPath = public_path($relativeDestination);
             $safeName = "image".time().'.'.$extension;
             $file->move($destinationPath, $safeName);
             $path = url("$relativeDestination/$safeName");
             
         }
         $data['image'] = $path;

         }
 
            $liturgicalText = new LiturgicalText();
            $liturgicalText->title = $data['title'];
            $liturgicalText->contenu = $data['contenu'];
            $liturgicalText->image = $data['image'];
            $liturgicalText->type_entry_type_id = $data['type_entry_type_id'];
            $liturgicalText->parish_id = $data['parish_id'];
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
            
         ]);

         if(isset($req->image)){
            $file = $req->file('image');
            $path = null;
            if($file != null){
             $extension = $file->getClientOriginalExtension();
             $relativeDestination = "uploads/liturgicals/backgrounds";
             $destinationPath = public_path($relativeDestination);
             $safeName = "image".time().'.'.$extension;
             $file->move($destinationPath, $safeName);
             $path = url("$relativeDestination/$safeName");
             if ($liturgical->image) {
                $oldImagePath = public_path($liturgical->image);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
         }
         $data['image'] = $path;

         }
         

        
         if ( $data['title']) $liturgical->title = $data['title'];
         if ( $data['contenu']) $liturgical->contenu = $data['contenu'];
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
        $liturgicaltext = [
          'id' => $liturgical->id,
          'title' =>  $liturgical->title,
          'contenu' => $liturgical->contenu,
          'image' => $liturgical->image,
          'type_id'=>$liturgical->type_entry_type_id,
          'parish_id'=>$liturgical->parish_id
        ];
        return response()->json($liturgicaltext);
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

    public function findLiturgicalByType($slug, $parishId)
    {
        $liturgical = LiturgicalText::select('liturgical_texts.title','liturgical_texts.id',
                                            'liturgical_texts.parish_id', 
                                            'entry_types.title as type_title',
                                            'liturgical_types.slug')
                                            ->where(['liturgical_types.slug' => $slug])
                                            ->where(['liturgical_texts.parish_id' => $parishId])
                                            ->join('liturgical_type_entry_types', 'liturgical_texts.type_entry_type_id', '=', 'liturgical_type_entry_types.id')
                                            ->join('liturgical_types', 'liturgical_type_entry_types.type_id', '=', 'liturgical_types.id')
                                            ->join('entry_types', 'liturgical_type_entry_types.entry_type_id', '=', 'entry_types.id')
                                            ->join('parishs', 'liturgical_texts.parish_id', '=', 'parishs.id')
                                            ->get()
                                            ->groupBy('type_title');
        return response()->json($liturgical);
    }
}