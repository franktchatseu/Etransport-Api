<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\Membre;
use Illuminate\Http\Request;

class MembreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        {
            $data = Membre::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'        
        ]);

        $data = Membre::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function generateMatricule(){
        $chars='01234567abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string='';
        for($i=0;$i<50;$i++){
           $string =$chars[rand(0,strlen($chars)-1)];
        }
        return string;
    }
    public function create(Request $request)
    {

        $data = $request->only([
            'file',
            'adhesion_date',
            'is_finish',
            'status'
        ]);

        $this->validate($data, [
            'is_finish' => 'required',
            'adhesion_date' => 'min:2',
            'status' => 'in:Rejected,Painding,Accepted',
        ]);

        $chars='01234567abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string='';
        for($i=0;$i<5;$i++){
           $string =$chars[rand(8,strlen($chars)-1)];
        }

        if(isset($request->file)){
            $file = $request->file('file');
            $path = null;
            if($file != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/membres";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
            }
            $data['file'] = $path;
        }

        $membre=new Membre();
        $membre->matricule=$string;
        $membre->adhesion_date=$data['adhesion_date'];
        $membre->status=$data['status'];
        $membre->file=$data['file'];
        $membre->is_finish=$data['is_finish'];
        

        $membre->save();

        return response()->json($membre);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catechesis\Membre  $membre
     * @return \Illuminate\Http\Response
     */
    public function show(Membre $membre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catechesis\Membre  $membre
     * @return \Illuminate\Http\Response
     */
    public function edit(Membre $membre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\Membre  $membre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $membre = Membre::find($id);
        if (!$membre) {
            abort(404, "No Member found with id $id");
        }
       
        
        $data = $request->only([
            'file',
            'adhesion_date',
            'is_finish',
            'status'
        ]);

        

        $this->validate($data, [
            'is_finish' => 'required',
            'adhesion_date' => 'required',
            'status' => 'in:Rejected,Painding,Accepted',
        ]);

        //upload image
        if(isset($request->file)){
            $file = $request->file('file');
            $path = null;

            if($file != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/membres";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
                if ($membres->file) {
                    $oldImagePath = public_path($membres->file);
                    if (file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                }
            }
            $data['file'] = $path;
        }

        if (null!==$data['status']){
            $membre->status=$data['status'];
           }
        if (null!==$data['file']){
            $membre->file=$data['file'];
           }
        if (null!==$data['is_finish']){
            $membre->is_finish=$data['is_finish'];
           }
        if (null!==$data['adhesion_date']){
            $membre->adhesion_date=$data['adhesion_date'];
           }

           $membre->update();

       return response()->json($membre);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catechesis\Membre  $membre
     * @return \Illuminate\Http\Response
     */

    public function find($id)
    {
        if (!$membre = Membre::find($id)) {
            abort(404, "No membre found with id $id");
        }
        return response()->json($membre);
    }

    public function destroy($id)
    {
        if (!$membre = Membre::find($id)) {
            abort(404, "No Membre found with id $id");
        }

        $membre->delete();      
        return response()->json();
    }
}
