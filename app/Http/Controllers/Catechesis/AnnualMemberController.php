<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\AnnualMember;
use App\Models\Catechesis\Member;
use Illuminate\Http\Request;
use App\Models\Catechesis\Evaluation;
use App\Models\Catechesis\Quarter;
use App\Models\APIError;

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
            'has_win',
            'quarter_id'
        ]);

        $this->validate($data, [
            'class' => 'required|string|min:2',
            'has_win' => 'required',
            'quarter_id' => 'required:exists:quarters,id'
        ]);

        $annualMember = new AnnualMember();
        $annualMember->class=$data['class'];
        $annualMember->has_win=$data['has_win'];
        $annualMember->quarter_trimestre_id =$data['quarter_id'];

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
        $annualMember = AnnualMember::find($id);
        if (!$annualMember) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("AnnuelMEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $request->only([
            'context',
            'has_win',
            'quarter_id'
        ]);

        $this->validate($data, [
            'class' => 'required|string|min:2',
            'has_win' => 'required',
            'quarter_id' => 'required:exists:quarters,id'
        ]);

       if ( $data['class'] ?? null){
        $annualMember->class=$data['class'];
       }
       if (null!==$data['quarter_id'] ?? null){
        $annualMember->quarter_id =$data['quarter_id'];
       }
       if (null!==$data['has_win'] ?? null){
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
        $annualMember = AnnualMember::find($id);
        if (!$annuelMember) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("AnnuelMEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
            return response()->json($annualMember);
    }

    public function getMemberByClass(Request $request,$id)
    {
        $Member = Member::find($id);
        if (!$Member) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $data = AnnualMember::whereMember_id($id)->get();
            return response()->json($data);
    }
    
        public function destroy($id)
        {
        
        $annualMember = AnnualMember::find($id);
        if (!$annuelMember) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("AnnuelMEMBER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
    
            $annualMember->delete();      
            return response()->json();
        }


    public function findEvaluations(Request $req, $id)
    {
        $annualMember = AnnualMember::find($id);
        if (!$annualMember) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $evaluations =  Evaluation::whereAnnualMemberId($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($evaluations);
    }
}


