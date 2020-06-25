<?php

namespace App\Http\Controllers\Sacrament;

use App\Http\Controllers\Controller;
use App\Models\Sacrament\Sacrament;
use Illuminate\Http\Request;

class SacramentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Sacrament::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'category_id' => 'required:exists:sacrament_categories,id'
         ]);

         if(isset($req->composition_file)){
            $file = $req->file('composition_file');
            $path = null;
            if($file != null){
                $req->validate(['composition_file'=>'file|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/sacraments";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document_composition".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
            }
            $data['composition_file'] = $path;
        }  
        
        if(isset($req->inscription_file)){
            $file = $req->file('inscription_file');
            $path = null;
            if($file != null){
                $req->validate(['inscription_file'=>'file|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/sacraments";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document_inscription".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
            }
            $data['inscription_file'] = $path;
        }

            $sacrament = new Sacrament();
            $sacrament->title = $data['title'];
            $sacrament->description = $data['description'];
            $sacrament->category_id = $data['category_id'];
            $sacrament->composition_file = $data['composition_file'];
            $sacrament->inscription_file = $data['inscription_file'];
            $sacrament->save();
       
        return response()->json($sacrament);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sacrament\Sacrament  $sacrament
     * @return \Illuminate\Http\Response
     */
    public function show(Sacrament $sacrament)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sacrament\Sacrament  $sacrament
     * @return \Illuminate\Http\Response
     */
    public function edit(Sacrament $sacrament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sacrament\Sacrament  $sacrament
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $sacrament = Sacrament::find($id);
        if (!$sacrament) {
            abort(404, "No sacrament found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required:exists:sacrament_categories,id',
         ]);

         if(isset($req->composition_file)){
            $file = $req->file('composition_file');
            $path = null;

            if($file != null){
                $req->validate(['composition_file'=>'file|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/sacraments";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document_composition".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
                if ($sacrament->composition_file) {
                    $oldImagePath = public_path($sacrament->composition_file);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['composition_file'] = $path;
        }

        if(isset($req->inscription_file)){
            $file = $req->file('inscription_file');
            $path = null;

            if($file != null){
                $req->validate(['inscription_file'=>'file|max:20000']);
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/sacraments";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document_inscription".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
                if ($sacrament->inscription_file) {
                    $oldImagePath = public_path($sacrament->inscription_file);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['inscription_file'] = $path;
        }
        
        if ( $data['title']) $sacrament->title = $data['title'];
        if ( $data['description']) $sacrament->description = $data['description'];
        if ( $data['category_id']) $sacrament->category_id = $data['category_id'];
        if ( $data['composition_file']) $sacrament->composition_file = $data['composition_file'];
        if ( $data['inscription_file']) $sacrament->inscription_file = $data['inscription_file'];

        
        $sacrament->update();

        return response()->json($sacrament);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sacrament\Sacrament  $sacrament
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$sacrament = Sacrament::find($id)) {
            abort(404, "No Sacrament found with id $id");
        }

        $sacrament->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Sacrament::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$sacrament = Sacrament::find($id)) {
            abort(404, "No Sacrament found with id $id");
        }
        $sacrament->composition_file = url($sacrament->composition_file);
        $sacrament->inscription_file = url($sacrament->inscription_file);
        return response()->json($sacrament);
    }
}
