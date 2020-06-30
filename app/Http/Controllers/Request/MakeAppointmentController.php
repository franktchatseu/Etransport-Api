<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request\MakingAppointment;
use App\Models\APIError;

/**
     * CRUD of objectMakingAppointment
     * @author tchamou ramses
     * @email tchamouramses@gmail.com
*/

class MakeAppointmentController extends Controller
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
        $data = MakingAppointment::simplePaginate($req->has('limit') ? $req->limit : 15);
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
        $datas = $request->all();
        $this->validate($datas, [
            'hour' => 'required',
            'date' => 'required',
            'person_id' => 'required',
            'object_id' => 'required'
        ]);

        $data = new MakingAppointment();
        $data->hour = $datas['hour'];
        $data->date = $datas['date'];
        $data->comment = $datas['comment'] ?? null;
        $data->object_id = $datas['object_id'];
        $data->person_id = $datas['person_id'];
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
        $data = MakingAppointment::find($id);
        if (!$data) {
            abort(404, "No MakingAppointment found with id $id");
        }

        $datas = $req->all();

        if (null !== $data['hour']) $data->hour = $datas['hour'];
        if (null !== $data['date']) $data->date = $datas['date'];
        if (null !== $data['comment']) $data->comment = $datas['comment'];
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
        if (!$data = MakingAppointment::find($id)) {
            abort(404, "No MakingAppointment found with id $id");
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

        $data = MakingAppointment::where($req->field, 'like', "%$req->q%")
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
        if (!$data = MakingAppointment::find($id)) {
            abort(404, "No MakingAppointment found with id $id");
        }
        return response()->json($data);
    }

    public function findAllForUser(Request $req, $id)
    {
        $data = MakingAppointment::wherePerson_id($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("MakingAppointment_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }
}
