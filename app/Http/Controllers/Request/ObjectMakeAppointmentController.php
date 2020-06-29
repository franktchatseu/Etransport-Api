<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\APIError;
use App\Models\Request\ObjectMakingAppointment;

class ObjectMakeAppointmentController extends Controller
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
        $data = ObjectMakingAppointment::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'type' => 'required',
            'description' => 'required',
            'label' => 'required',
        ]);

        $data = new ObjectMakingAppointment();
        $data->type = $datas['type'];
        $data->description = $datas['description'];
        $data->label = $datas['label'];

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
        $data = ObjectMakingAppointment::find($id);
        if (!$data) {
            abort(404, "No ObjectMakingAppointment found with id $id");
        }

        $datas = $req->except('photo');

        // $this->validate($data, [
        //     'assisted_person' => 'required',
        //     'age' => 'required',
        //     'gender' => 'required',
        //     'quater' => 'required',
        //     'disease_nature' => 'required',
        //     'is_baptisted' => 'required',
        //     'date' => 'required',
        // ]);

        if (null !== $data['type']) $data->type = $datas['type'];
        if (null !== $data['description']) $data->description = $datas['description'];
        if (null !== $data['label']) $data->label = $datas['label'];

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
        if (!$data = ObjectMakingAppointment::find($id)) {
            abort(404, "No ObjectMakingAppointment found with id $id");
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

        $data = ObjectMakingAppointment::where($req->field, 'like', "%$req->q%")
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
        if (!$data = ObjectMakingAppointment::find($id)) {
            abort(404, "No ObjectMakingAppointment found with id $id");
        }
        return response()->json($data);
    }

    public function findByType(Request $req, $type)
    {
        $data = ObjectMakingAppointment::whereType($type)->simplePaginate($req->has('limit') ? $req->limit : 1000);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ObjectMakingAppointment_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }
}
