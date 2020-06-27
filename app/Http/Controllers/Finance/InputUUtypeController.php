<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Finance\InputUUtype;
use App\Models\Finance\Input;
use App\Models\Finance\Nature;
use App\Models\Person\UserUtype;
use App\Models\Person\User;
use Carbon\Carbon;




class InputUUtypeController extends Controller
{
     /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = InputUUtype::simplePaginate($req->has('limit') ? $req->limit : 15);
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
     * Create a request For Mass on database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [

            'input_id' => 'required',
            'user_utype_id' => 'required',
            'transaction_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'city' => 'required',
            'provenance' => 'required',
            'country' => 'required',
            'pseudo' => 'required',
        ]);
        
        $uutype = UserUtype::find($request->user_utype_id);
        if($uutype == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("INPUTUUTYPE_NOT_FOUND");
            $notFound->setMessage("user-utype with id " . $request->user_utype_id. " not found");

            return response()->json($notFound, 404);
        }

        $input = Input::find($request->input_id);
        if($input == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("INPUT_NOT_FOUND");
            $notFound->setMessage("input with id " . $request->input_id . " not found");

            return response()->json($notFound, 404);
        }

            $inputuutype = new InputUUtype();
            $inputuutype->user_utype_id = $uutype->id;
            $inputuutype->input_id = $input->id;
            $inputuutype->transaction_id = $data['transaction_id'];
            $inputuutype->amount = $data['amount'];
            $inputuutype->date = $data['date'];
            $inputuutype->city = $data['city'];
            $inputuutype->provenance = $data['provenance'];
            $inputuutype->country = $data['country'];
            $inputuutype->pseudo = $data['pseudo'];
            $inputuutype->save();
       
        return response()->json($inputuutype);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(InputUUtype $inputuutype)
    {
        //
    }

    /**
     * Create a request For Mass on database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(InputUUtype $inputuutype)
    {
        //
    }

    
   /**
     * Create a request For Mass on database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        // $inputuutype = InputUUtype::find($id);
        // if($inputuutype == null) {
        //     $notFound = new APIError;
        //     $notFound->setStatus("404");
        //     $notFound->setCode("REQUESTFORMASS_NOT_FOUND");
        //     $notFound->setMessage("inputuutype with id " . $id . " not found");

        //     return response()->json($notFound, 404);
        // }

        // $data = $req->except('photo');

        // $this->validate($data, [
        //     'title' => 'required',
        //     'description' => 'required'
        // ]);

        // if ( $data['title']) $inputuutype->title = $data['title'];
        // if ( $data['description']) $inputuutype->description = $data['description'];
        
        // $inputuutype->update();

        // return response()->json($inputuutype);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inputuutype = InputUUtype::find($id);
        if($inputuutype == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("REQUESTFORMASS_NOT_FOUND");
            $notFound->setMessage("inputuutype with id " . $id . " not found");

            return response()->json($notFound, 404);
        }

        $inputuutype->delete();      
        return response()->json();
    }
/**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = InputUUtype::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $inputuutype = InputUUtype::find($id);
        if($inputuutype == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("INPUTUUTYPE_NOT_FOUND");
            $notFound->setMessage("inputuutype with id " . $id . " not found");

            return response()->json($notFound, 404);
        }
        return response()->json($inputuutype);
    }

    public function findTransactionByUser(Request $req, $id)
    {
        $user = User::find($id);
        if($user == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("USER_NOT_FOUND");
            $notFound->setMessage("User with id " . $id . " not found");

            return response()->json($notFound, 404);
        }
            $transaction = InputUUtype::select('input_uutypes.*')
                ->join('user_utypes', 'input_uutypes.user_utype_id', '=', 'user_utypes.id')
                ->join('users', 'user_utypes.user_id', '=', 'users.id')
                ->where(['users.id' => $id])->orderBy('date', 'desc')
                ->simplePaginate($req->has('limit') ? $req->limit : 15)
                ->groupBy(function($date) {
                    return Carbon::parse($date->created_at)->format('M');
                });
                
            return response()->json($transaction);
            
    }   
    
    
    public function findTransactionByNature(Request $req)
    {
        $this->validate($req->all(), [
            'name' => 'present',
        ]);
        $name = $req->name;
        $natures =  Nature::whereName($name)->first();

        if($natures == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("NATURE_NOT_FOUND");
            $notFound->setMessage("Nature with the name " . $req->name . " not found");

            return response()->json($notFound, 404);
        }
            $transaction = InputUUtype::select('input_uutypes.*')
                ->join('inputs', 'input_uutypes.input_id', '=', 'inputs.id')
                ->join('natures', 'inputs.nature_id', '=', 'natures.id')
                ->where(['natures.id' => $natures->id])->orderBy('input_uutypes.date', 'desc')
                ->simplePaginate($req->has('limit') ? $req->limit : 15);
            return response()->json($transaction);
    }   
    
}
