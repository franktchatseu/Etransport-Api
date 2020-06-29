<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\Request\IntentionMass;
use Illuminate\Http\Request;

class IntentionMassController extends Controller
{
        /**
     * Display a list of Anointing Sick from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = IntentionMass::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }


    /**
     * Create an Anointing Sick on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = $request->except('photo');
        $this->validate($datas, [
            'date' => 'required',
            'intention' => 'required',
            'mass' => 'required',
            'amount' => 'required',
            'person_id' => 'required',
        ]);

        $data = new IntentionMass();
        $data->date = $datas['data'];
        $data->intention = $datas['intention'];
        $data->content = $datas['content'];
        $data->mass = $datas['mass'];
        $data->amount = $datas['amount'];
        $data->status = 'PENDING';
        $data->person_id = $datas['person_id'];

        $data->save();

        return response()->json($data);
    }

    /**
     * Update an Anointing Sick on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $data = IntentionMass::find($id);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("IntentionMass_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $datas = $req->all();

        // $this->validate($data, [
        //     'assisted_person' => 'required',
        //     'age' => 'required',
        //     'gender' => 'required',
        //     'quater' => 'required',
        //     'disease_nature' => 'required',
        //     'is_baptisted' => 'required',
        //     'date' => 'required',
        // ]);

        if (null !== $data['date']) $data->date = $datas['date'];
        if (null !== $data['intention']) $data->intention = $datas['intention'];
        if (null !== $data['content']) $data->content = $datas['content'];
        if (null !== $data['mass']) $data->mass = $datas['mass'];
        if (null !== $data['amount']) $data->amount = $datas['amount'];
        if (null !== $data['status']) $data->status = $datas['status'];
    
        $data->update();

        return response()->json($data);
    }

    /**
     * Remove an Anointing Sick from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$data = IntentionMass::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("IntentionMass_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data->delete();
        return response()->json();
    }

    /**
     * Search an Anointing Sick from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = IntentionMass::where($req->field, 'like', "%$req->q%")
            ->get();

        return response()->json($data);
    }

    /**
     * Find an Anointing Sick from database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        if (!$data = IntentionMass::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("IntentionMass_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }

    public function findAllForUser(Request $req, $id)
    {
        $data = IntentionMass::wherePerson_id($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("IntentionMass_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }
}
