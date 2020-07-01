<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\RequestMass;
use App\Models\APIError;

class RequestMassController extends Controller
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
        $data = RequestMass::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'hour' => 'required',
            'date' => 'required',
            'place' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'object_id' => 'required',
            'person_id' => 'required',
            'priest_id' => 'required',
        ]);

        $data = new RequestMass();
        $data->hour = $datas['hour'];
        $data->date = $datas['date'];
        $data->place = $datas['place'];
        $data->description = $datas['description'];
        $data->amount = $datas['amount'];
        $data->object_id = $datas['object_id'];
        $data->person_id = $datas['person_id'];
        $data->priest_id = $datas['priest_id'];
        $data->status = 'PENDING';

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
        $data = RequestMass::find($id);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("RequestMass_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $datas = $req->except('photo');

        if (null !== $data['hour']) $data->hour = $datas['hour'];
        if (null !== $data['date']) $data->date = $datas['date'];
        if (null !== $data['place']) $data->place = $datas['place'];
        if (null !== $data['description']) $data->description = $datas['description'];
        if (null !== $data['amount']) $data->amount = $datas['amount'];
        if (null !== $data['object_id']) $data->object_id = $datas['object_id'];
        if (null !== $data['priest_id']) $data->priest_id = $datas['priest_id'];
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
        if (!$data = RequestMass::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("RequestMass_NOT_FOUND");
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

        $data = RequestMass::where($req->field, 'like', "%$req->q%")
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
        if (!$data = RequestMass::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("RequestMass_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }

    public function findAllForUser(Request $req, $id)
    {
        $data = RequestMass::wherePerson_id($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("RequestMass_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }
}
