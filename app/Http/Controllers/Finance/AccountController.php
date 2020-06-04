<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Account;
use Illuminate\Http\Request;
use App\Models\APIError;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Account::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->only([
            'basic_amount',
            'percentage',
            'final_amount',
            'accounttype_id'
        ]);

        $this->validate($data, [
            'basic_amount' => 'required',
            'percentage' => 'required',
            'final_amount' => 'required',
           // 'accounttype_id' => 'required:exists:account_types,id'
         ]);

            $account = new Account();
            $account->basic_amount = $data['basic_amount'];
            $account->percentage = $data['percentage'];
            $account->final_amount = $data['final_amount'];
            $account->accounttype_id = $data['accounttype_id'];
            $account->save();
       
        return response()->json($account);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finance\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $account = Account::find($id);
        if($account == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ACCOUNT_NOT_FOUND");
            $notFound->setMessage("account with id " . $id . " not found");

            return response()->json($notFound, 404);
        }
        return response()->json($account);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Account::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finance\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $account = Account::find($id);
        if($account == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ACCOUNT_NOT_FOUND");
            $notFound->setMessage("account with id " . $id . " not found");

            return response()->json($notFound, 404);
        }

        $data = $req->only([
            'basic_amount',
            'percentage',
            'final_amount',
            'accounttype_id'
        ]);

        $this->validate($data, [
            'basic_amount' => 'required',
            'percentage' => 'required',
            'final_amount' => 'required',
           // 'accounttype_id' => 'required:exists:account_types,id'
         ]);

        
        if (null !== $data['basic_amount']) $account->basic_amount = $data['basic_amount'];
        if (null !== $data['percentage']) $account->percentage = $data['percentage'];
        if (null !== $data['final_amount']) $account->final_amount = $data['final_amount'];
        if (null !== $data['accounttype_id']) $account->accounttype_id = $data['accounttype_id'];
        
        $account->update();

        return response()->json($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::find($id);
        if($account == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ACCOUNT_NOT_FOUND");
            $notFound->setMessage("account id not found");

            return response()->json($notFound, 404);
        }

        $account->delete();      
        return response()->json();
    }
}
