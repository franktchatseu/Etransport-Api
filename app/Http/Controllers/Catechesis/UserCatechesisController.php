<?php

namespace App\Http\Controllers\Catechesis;

use App\Http\Controllers\Controller;
use App\Models\Catechesis\UserCatechesis;
use Illuminate\Http\Request;

class UserCatechesisController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function index (Request $req)
    {
        $data = UserCatechesis::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('photo');

        $this->validate($data, [
            'user_utype_id' => 'required',
            'catechesis_id' => 'required'
        ]);

            $userCatechesis = new UserCatechesis();
            $userCatechesis->user_utype_id = $data['user_utype_id'];
            $userCatechesis->catechesis_id = $data['catechesis_id'];
            $userCatechesis->save();
       
        return response()->json($userCatechesis);
    }

   /**
     * Create a request For Mass on database
     * @author jiozang theophane
     * @email jiozangtheophane@gmail.com
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $userCatechesis = UserCatechesis::find($id);
        if (!$userCatechesis) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USERCATECHESIS_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'user_utype_id' => 'required',
            'catechesis_id' => 'required'
        ]);

        if ( $data['user_utype_id']) $userCatechesis->user_utype_id = $data['user_utype_id'];
        if ( $data['catechesis_id']) $userCatechesis->catechesis_id = $data['catechesis_id'];
        $userCatechesis->update();

        return response()->json($userCatechesis);
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userCatechesis = UserCatechesis::find($id);
        if (!$userCatechesis) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USERCATECHESIS_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $userCatechesis->delete();      
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

        $data = UserCatechesis::where($req->field, 'like', "%$req->q%")
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
        $userCatechesis = UserCatechesis::find($id);
        if (!$userCatechesis) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USERCATECHESIS_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($userCatechesis);
    }

    public function findUserCatechesis(Request $req, $id)
    {
        $userCatechesis = UserCatechesis::select('user_catechesis.*','user_catechesis.id as user_catechesis_id','catechesis.*')
        ->join('catechesis', 'user_catechesis.catechesis_id', '=', 'catechesis.id' )
        ->where(['user_catechesis.user_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($userCatechesis);
    }
    public function findNameUserCatechesis(Request $req, $id)
    {
        $userNameCatechesis = UserCatechesis::select('user_catechesis.*','user_catechesis.id as user_catechesis_id','users.*')
        ->join('users', 'user_catechesis.users_id', '=', 'users.id' )
        ->where(['user_catechesis.user_id' => $id])
        ->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($userNameCatechesis);
    }
}
