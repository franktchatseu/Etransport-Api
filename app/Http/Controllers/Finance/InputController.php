<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Input;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Finance\Nature;
use App\Models\Person\UserUtype;
use App\Models\Person\User;
use App\Models\Setting\Parish;
use Carbon\Carbon;

class InputController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Input::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = $request->except('bill');

        $this->validate($data, [
            'reason' => 'required',
            'nature_id' => 'required|exists:natures,id',
            'transaction_id' => 'required',
            'date' => 'required',
            'city' => 'required',
            'provenance' => 'required',
            'reference' => 'required',
            'country' => 'required|string',
            'parish_id' => 'required|exists:natures,id',
            
        ]);
        
        $input = new Input();

        if($request->user_utype_id){
            $uutype = UserUtype::find($request->user_utype_id);
            if($uutype == null) {
                $notFound = new APIError;
                $notFound->setStatus("404");
                $notFound->setCode("INPUTUUTYPE_NOT_FOUND");
                $notFound->setMessage("user-utype with id " . $request->user_utype_id. " not found");
    
                return response()->json($notFound, 404);
            }
            $input->user_utype_id = $uutype->id;
        }
       
        
        $nature = Nature::find($request->nature_id);
        if($nature == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("NATURE_NOT_FOUND");
            $notFound->setMessage("nature_id with id " . $request->nature_id . " not found");

            return response()->json($notFound, 404);
        }

        $parish = Parish::find($request->parish_id);
        if($parish == null) {
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ENTER_THE_PARISH_ID");
            $notFound->setMessage("parish_id does not exist");
            return response()->json($notFound, 404);
        }

        // $namepdf =$request->provenance.'_'.$request->city.'.pdf';
        // $pdf = PDF::loadHtml($request->amount);
        // $pdf->save(public_path('/uploads/bills/').$namepdf);
        
        
        
        $input->transaction_id = $data['transaction_id'];
        if ($request->date) $input->date = $data['date'];
        $input->city = $data['city'];
        $input->provenance = $data['provenance'];
        $input->country = $data['country'];
        if ($request->pseudo) $input->pseudo = $data['pseudo'];
        $input->parish_id = $data['parish_id'];
        $input->reference = $data['reference'];
        if ($request->amount) $input->amount = $data['amount'];
        if ($request->description) $input->description = $data['description'];
        if ($request->reason) $input->reason = $data['reason'];
        if ($request->start_date) $input->start_date = $data['start_date'];
        if ($request->end_date) $input->end_date = $data['end_date'];
        $input->nature_id = $data['nature_id'];
        if ($request->status) $input->status = $request->status;
        if(isset($request->bill)){
            $file = $request->file('bill');
            $path = null;
            if($file != null){
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/bills";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
            }
            $input->bill_url = url($path);
        }else{
            return response()->json("bill is require", 400); 
        }
        $input->save();
       
        return response()->json($input);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finance\Input  $input
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        if (!$input =Input::find($id)) {
            abort(404, "No input$input found with id $id");
        }
        return response()->json($input);
    }

    
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Input::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finance\Input  $input
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $input = Input::find($id);
        if (!$input) {
            abort(404, "No input found with id $id");
        }

        $data = $req->only([
            'amount',
            'description',
            'reason',
            'start_date',
            'end_date',
            'nature_id',    
        ]);

        $this->validate($data, [
            'amount' => 'required',
            'reason' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            //'nature_id' => 'required:exists:nature,id'
         ]);

        
        if (null !== $data['amount']) $input->amount = $data['amount'];
        if (null !== $data['description']) $input->description = $data['description'];
        if (null !== $data['reason']) $input->reason = $data['reason'];
        if (null !== $data['start_date']) $input->start_date = $data['start_date'];
        if (null !== $data['end_date']) $input->end_date = $data['end_date'];
        if (null !== $data['nature_id']) $input->nature_id = $data['nature_id'];
        
        $input->update();

        return response()->json($input);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance\Input  $input
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$input = Input::find($id)) {
            abort(404, "No input$input found with id $id");
        }

        $input->delete();      
        return response()->json();
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
       
        if($req->parish_id){
            $parish = Parish::find($req->parish_id);
            if($parish== null) {
                $notFound = new APIError;
                $notFound->setStatus("404");
                $notFound->setCode("PARISH_NOT_FOUND");
                $notFound->setMessage("PARISH with id " . $req->parish_id . " not found");
    
                return response()->json($notFound, 404);
            }
            $transaction = Input::select('inputs.*', 'natures.name as nature_name')
            ->join('user_utypes', 'inputs.user_utype_id', '=', 'user_utypes.id')
            ->join('users', 'user_utypes.user_id', '=', 'users.id')
            ->join('parishs', 'inputs.parish_id', '=', 'parishs.id')
            ->join('natures', 'inputs.nature_id', '=', 'natures.id')
            ->where(['parishs.id' => $req->parish_id])
            ->where(['users.id' => $id])->orderBy('inputs.id', 'desc')
            ->simplePaginate($req->has('limit') ? $req->limit : 15)
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y');
            });
            
            
        return response()->json($transaction);
        
        }else{
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ENTER_THE_PARISH_ID");
            $notFound->setMessage("parish_id does not exist");

            return response()->json($notFound, 401);
        }
           
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

        if($req->parish_id){


        }else{
            $notFound = new APIError;
            $notFound->setStatus("404");
            $notFound->setCode("ENTER_THE_PARISH_ID");
            $notFound->setMessage("parish_id does not exist");

            return response()->json($notFound, 401);
        }
            $transaction = InputUUtype::select('input_uutypes.*','natures.*')
                ->join('inputs', 'input_uutypes.input_id', '=', 'inputs.id')
                ->join('natures', 'inputs.nature_id', '=', 'natures.id')
                ->join('parishs', 'input_uutypes.parish_id', '=', 'parishs.id')
                ->where(['natures.id' => $natures->id],['parishs.id' => $req->parish_id])->orderBy('input_uutypes.date', 'desc')
                ->simplePaginate($req->has('limit') ? $req->limit : 15)->groupBy(function($date) {
                    return Carbon::parse($date->created_at)->format('Y');
                });
            return response()->json($transaction);
    }   
    
}

    


