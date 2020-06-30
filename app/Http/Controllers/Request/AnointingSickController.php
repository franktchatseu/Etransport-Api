<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\APIError;
use App\Models\Request\AnointingSick;
use Illuminate\Http\Request;

class AnointingSickController extends Controller
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
        $data = AnointingSick::simplePaginate($req->has('limit') ? $req->limit : 15);
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
            'assisted_person' => 'required',
            'age' => 'required',
            'gender' => 'required|in:M,F',
            'quater' => 'required',
            'disease_nature' => 'required',
            'is_baptisted' => 'required',
            'date' => 'required',
            'hour' => 'required',
            'comment' => 'required',
            'person_id' => 'required',
            // 'status' => 'required|in:REJECTED,PENDING,ACCEPTED',
        ]);

        if ($request->file('avatar') ?? null) {
            $filePaths = $this->saveSingleImage($this, $request, 'avatar', 'anoitings');
            $datas['avatar'] = json_encode(['images' => $filePaths]);
        }

        $data = new AnointingSick();
        $data->avatar = $datas['avatar'] ?? null;
        $data->assisted_person = $datas['assisted_person'];
        $data->age = $datas['age'];
        $data->gender = $datas['gender'];
        $data->quater = $datas['quater'];
        $data->disease_nature = $datas['disease_nature'];
        $data->is_baptisted = $datas['is_baptisted'];
        $data->date = $datas['date'];
        $data->hour = $datas['hour'];
        $data->comment = $datas['comment'];
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
        $data = AnointingSick::find($id);
        if (!$data) {
            abort(404, "No anointingSick found with id $id");
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

        if ($file = $req->file('avatar')) {
            $filePaths = $this->saveSingleImage($this, $req, 'avatar', 'anoiting');
            $datas['avatar'] = json_encode(['images' => $filePaths]);
        }

        if (isset($data['avatar']))
            $data->avatar = $datas['avatar'];

        if (null !== $data['assisted_person']) $data->assisted_person = $datas['assisted_person'];
        if (null !== $data['age']) $data->age = $datas['age'];
        if (null !== $data['gender']) $data->gender = $datas['gender'];
        if (null !== $data['quater']) $data->quater = $datas['quater'];
        if (null !== $data['disease_nature']) $data->disease_nature = $datas['disease_nature'];
        if (null !== $data['is_baptisted']) $data->is_baptisted = $datas['is_baptisted'];
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
        if (!$data = AnointingSick::find($id)) {
            abort(404, "No anointingSick found with id $id");
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

        $data = AnointingSick::where($req->field, 'like', "%$req->q%")
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
        if (!$data = AnointingSick::find($id)) {
            abort(404, "No anointingSick found with id $id");
        }
        return response()->json($data);
    }

    public function findAllForUser(Request $req, $id)
    {
        $data = AnointingSick::wherePerson_id($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$data) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("ANOINTINGSICK_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($data);
    }
}
