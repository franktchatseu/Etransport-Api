<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\AnnualMember;
use Illuminate\Http\Request;

class AnnualMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *by richie:richie richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        {
            $data = AnnualMember::simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($data);
        }
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'        
        ]);

        $data = AnnualMember::where($req->field, 'like', "%$req->q%")->get();

        return response()->json($data);
    }


    /**
     * Show the form for creating a new resource.
     **by richie:richie richienebou@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data = $request->only([
            'class',
            'has_win'
        ]);

        $this->validate($data, [
            'class' => 'required|string|min:2',
            'has_win' => 'required'
        ]);

        $annualMember = new AnnualMember();
        $annualMember->class=$data['class'];
        $annualMember->has_win=$data['has_win'];

        $annualMember->save();

        return response()->json($annualMember);
    }

    /**
     * Store a newly created resource in storage.
     **by richie:richie richienebou@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     **by richie:richie richienebou@gmail.com
     * @param  \App\Models\Catechesis\AnnualMember  $AnnualMember
     * @return \Illuminate\Http\Response
     */
    public function show(AnnualMember $AnnualMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     **by richie:richie richienebou@gmail.com
     * @param  \App\Models\Catechesis\AnnualMember  $AnnualMember
     * @return \Illuminate\Http\Response
     */
    public function edit(AnnualMember $AnnualMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     **by richie:richie richienebou@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\AnnualMember  $AnnualMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $annualMember = AnnualMember::find($id);
        if (!$annualMember) {
            abort(404, "No AnnualMember found with id $id");
        }

        $data = $request->only([
            'context',
            'has_win'
        ]);

        $this->validate($data, [
            'class' => '',
            'has_win' => 'required'
        ]);

       if (null !== $data['class']){
        $annualMember->class=$data['class'];
       }
       if (null!==$data['is_admin']){
        $annualMember->has_win=$data['has_win'];
       }
       

       $annualMember->update();

       return response()->json($annualMember);

    }


    /**
     * Remove the specified resource from storage.
     **by richie:richie richienebou@gmail.com
     * @param  \App\Models\Catechesis\AnnualMember  $AnnualMember
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
            if (!$annualMember = AnnualMember::find($id)) {
                abort(404, "No AnnualMember found with id $id");
            }
            return response()->json($annualMember);
        }
    
        public function destroy($id)
        {
            if (!$annualMember = AnnualMember::find($id)) {
                abort(404, "No annualMember found with id $id");
            }
    
            $annualMember->delete();      
            return response()->json();
        }
}


