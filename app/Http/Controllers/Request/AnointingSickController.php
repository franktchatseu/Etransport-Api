<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
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
    public function index (Request $req)
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
        $data = $request->except('photo');
        $this->validate($data, [
            'assisted_person' => 'required',
            'age' => 'required',
            'gender' => 'required|in:M,F',
            'quater' => 'required',
            'disease_nature' => 'required',
            'is_baptized' => 'required',
            'request_date' => 'required',
            'comment' => 'required',
            'person_id' => 'required',
            'status' => 'required|in:REJECTED,PENDING,ACCEPTED',
        ]);

        
        if ( $request->file('avatar') ?? null) {
            $filePaths = $this->saveSingleImage($this, $request, 'avatar', 'anoiting');
            $data['avatar'] = json_encode(['images' => $filePaths]);
            $anointingSick->avatar = $data['avatar'] ;
        }else{
            $anointingSick->avatar =null ;
        }

            $anointingSick = new AnointingSick();
            $anointingSick->assisted_person = $data['assisted_person'];
            $anointingSick->age = $data['age'];
            $anointingSick->gender = $data['gender'];
            $anointingSick->quater = $data['quater'];
            $anointingSick->disease_nature = $data['disease_nature'];
            $anointingSick->is_baptized = $data['is_baptized'];
            $anointingSick->request_date = $data['request_date'];
            $anointingSick->comment = $data['comment'];
            $anointingSick->status = $data['status'];
            $anointingSick->person_id = $data['person_id'];
 
            
            $anointingSick->save();
       
        return response()->json($anointingSick);
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
        $anointingSick = AnointingSick::find($id);
        if (!$anointingSick) {
            abort(404, "No anointingSick found with id $id");
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'assisted_person' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'quater' => 'required',
            'disease_nature' => 'required',
            'is_baptized' => 'required',
            'request_date' => 'required',
        ]);

        if ($file = $req->file('avatar')) {
            $filePaths = $this->saveSingleImage($this, $req, 'avatar', 'anoiting');
            $data['avatar'] = json_encode(['images' => $filePaths]);
        }
        
        if (isset($data['avatar']))
             $anointingSick->avatar = $data['avatar'];
        
        if (null !== $data['assisted_person']) $anointingSick->assisted_person = $data['assisted_person'];
        if (null !== $data['age']) $anointingSick->age = $data['age'];
        if (null !== $data['gender']) $anointingSick->gender = $data['gender'];
        if (null !== $data['quater']) $anointingSick->quater = $data['quater'];
        if (null !== $data['disease_nature']) $anointingSick->disease_nature = $data['disease_nature'];
        if (null !== $data['is_baptized']) $anointingSick->is_baptized = $data['is_baptized'];
        if (null !== $data['request_date']) $anointingSick->request_date = $data['request_date'];
        if (null !== $data['comment']) $anointingSick->comment = $data['comment'];
        if (null !== $data['status']) $anointingSick->status = $data['status'];

        $anointingSick->update();

        return response()->json($anointingSick);
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
        if (!$anointingSick = AnointingSick::find($id)) {
            abort(404, "No anointingSick found with id $id");
        }

        $anointingSick->delete();      
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
        if (!$anointingSick = AnointingSick::find($id)) {
            abort(404, "No anointingSick found with id $id");
        }
        return response()->json($anointingSick);
    }

    public function findAllForUser(Request $req, $id)
    {
        $evenement = AnointingSick::wherePerson_id($id)->simplePaginate($req->has('limit') ? $req->limit : 15);
        if (!$evenement) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("EVENEMENT_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($evenement);
    }
}
