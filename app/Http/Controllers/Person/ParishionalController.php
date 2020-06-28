<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Person\Parishional;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Person\User;

class ParishionalController extends Controller
{

    /**
     * create a parishioner by adding him directly as a user
     */
    public function create(Request $req)
    {
        $data = $req->except('files');

        $this->validate($data, [
            'login' => ['required', Rule::unique('users', 'login')],
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'district' => 'required',
            'password' => 'required|min:4',
            'profession_id' => ['required', 'exists:professions,id'],
            'quarter' => 'required',
            'isBaptist' => 'required',
        ]);

        $data['avatar'] = '';
        //upload image
        if ($file = $req->file('files')) {
            $filePaths = $this->saveMultipleImages($this, $req, 'files', 'users');
            $data['avatar'] = json_encode(['images' => $filePaths]);
        }

        
        $user = new User();
        $user->login = $data['login'];
        if($req->email) $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->avatar = $data['avatar'];
        if($req->gender) $user->gender = $data['gender'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        if($req->birth_date) $user->birth_date = $data['birth_date'];
        if($req->birth_place) $user->birth_place = $data['birth_place'];
        $user->district = $data['district'];
        if($req->is_baptisted) $user->is_baptisted = $data['is_baptisted'];
        if($req->baptist_date) $user->baptist_date = $data['baptist_date'];
        if($req->baptist_place) $user->baptist_place = $data['baptist_place'];
        if($req->language) $user->language = $data['language'];
        $user->profession_id = $data['profession_id'];
        if($req->tel) $user->tel = $data['tel'] ;
        if($req->is_married) $user->is_married = $data['is_married'];
        $user->save();

        $last_user = User::select(User::raw('max(id) as id'))->first();
        //dd($last_user->id);

        //$id = User::select("max(user_id)")->first();
        //dd($id);
        $parishional = new Parishional();
        $parishional->quarter = $data['quarter'];
        $parishional->isBaptist = $data['isBaptist'];
        $parishional->user_id = $last_user;
        //dd($parishional->quarter);
        $parishional->save();
        $user->parishional = $parishional;
        return response()->json($user);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = Parishional::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->except('photo');

        $this->validate($data, [
            'quarter' => 'required',
            'isBaptist' => 'required',
            'user_id' => 'required:exists:users,id'
         ]);


            $parishional = new Parishional();
            $parishional->quarter = $data['quarter'];
            $parishional->isBaptist = $data['isBaptist'];
            $parishional->user_id = $data['user_id'];
            $parishional->save();
       
        return response()->json($parishional);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person\Parishional  $parishional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        if (!$parishional = Parishional::find($id)){
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHIONAL_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('photo');

        $this->validate($data, [
            'quarter' => 'required',
            'isBaptist' => 'required'
         ]);

        
        if ( $data['quarter']) $parishional->quarter = $data['quarter'];
        if ( $data['isBaptist']) $parishional->isBaptist = $data['isBaptist'];
        
        $parishional->update();

        return response()->json($parishional);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person\Parishional  $parishional
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$parishional = Parishional::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHIONAL_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $parishional->delete();      
        return response()->json();
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);

        $data = Parishional::where($req->field, 'like', "%$req->q%")
            ->simplePaginate($req->has('limit') ? $req->limit : 15);

        return response()->json($data);
    }

    public function find($id)
    {
        if (!$parishional =Parishional::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("PARISHIONAL_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        return response()->json($parishional);
    }


}
