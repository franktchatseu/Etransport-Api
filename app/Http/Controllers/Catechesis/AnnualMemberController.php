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
     * Update the specified resource in storage.
     **by richie:richie richienebou@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catechesis\AnnualMember  $AnnualMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $annualMember = AnnuelMember::find($id);
        if (!$annuelMember) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("AnnuelMEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
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
        $annualMember = AnnuelMember::find($id);
        if (!$annuelMember) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("AnnuelMEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            return response()->json($annualMember);
        }
    
        public function destroy($id)
        {
            $annualMember = AnnuelMember::find($id);
        if (!$annuelMember) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("AnnuelMEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
    
            $annualMember->delete();      
            return response()->json();
        }
}


