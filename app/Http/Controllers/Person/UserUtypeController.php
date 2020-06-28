<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\APIError;
use App\Models\Person\UserUtype;
use Illuminate\Http\Request;
use App\Models\Person\Utype;

class UserUtypeController extends Controller
{
    /**
     * Display a list of person from database
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = Utype::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }
    
    /**
     * Create a person on database
     * @author Brell Sanwouo
     * @email sanwouobrell@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'type_id' => 'required',
            'user_id' => 'required:exists:users,id',
            'parish_id' => 'required'
        ]);

        $uutype = new UserUtype();
        $uutype->user_id = $data['user_id'];
        $uutype->type_id = $data['type_id'];
        $uutype->parish_id = $data['parish_id'];
        $uutype->save();
       
        return response()->json($uutype);
    }

    /**
     * Remove a person from database
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$uutype = UserUtype::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USERUTYPE_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $uutype->delete();      
        return response()->json();
    }

    /**
     * Search a person from database
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = UserUtype::where($req->field, 'like', "%$req->q%")
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function activateUserParish(Request $req, $id) {
        $data = $req->all();

        $this->validate($data, [
            'parish_id' => 'required:number',
        ]);

        UserUtype::where(['user_id' => $id])
        ->update(['is_active' => false]);

        UserUtype::where(['user_id' => $id, 'parish_id' => $req->parish_id])
        ->update(['is_active' => true]);

        return response()->json(['status' => 'Ok']);
    }

    public function findUserParishsWithStatus(Request $req, $id) {

        $parishs = UserUtype::select('user_utypes.*', 'user_utypes.id as user_utype_id', 'parishs.*', 'parishs.id as parish_id', 'user_utypes.is_active as parish_is_active')
        ->join('parishs', ['user_utypes.parish_id' => 'parishs.id' ])
        ->where(['user_utypes.user_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($parishs);
    }

    public function findUserByType(Request $req, $type) {

        $users = UserUtype::where(['utypes.value' => $type]) 
        ->join('utypes', ['utypes.id' => 'user_utypes.type_id' ])
        ->join('users', ['users.id' => 'user_utypes.user_id' ])
        ->join('parishs', ['user_utypes.parish_id' => 'parishs.id' ])
        ->select('users.*', 'user_utypes.*', 'user_utypes.id as user_utype_id', 'parishs.name as parish_name')        
        ->simplePaginate($req->has('limit') ? $req->limit : 6);

        return response()->json($users);
    }

}
