<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\APIError;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Person\User;

class UserController extends Controller
{
    public function index(Request $req)
    {
        $data = User::simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

    public function search(Request $req)
    {
        $this->validate($req->all(), [
            'q' => 'present',
            'field' => 'present'
        ]);
        $data = User::where($req->field, 'like', "%$req->q%")->simplePaginate($req->has('limit') ? $req->limit : 15);
        return response()->json($data);
    }

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
	    // 'profession' => ['required'],
            // 'email' => ['required', 'email', Rule::unique('users', 'email')],
        ]);

        $data['avatar'] = '';
        //upload image
        if ($file = $req->file('files')) {
            $filePaths = $this->saveMultipleImages($this, $req, 'files', 'users');
            $data['avatar'] = json_encode(['images' => $filePaths]);
        }

        
        $user = new User();
        $user->login = $data['login'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->avatar = $data['avatar'];
        $user->gender = $data['gender'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->birth_date = $data['birth_date'];
        $user->birth_place = $data['birth_place'];
        $user->district = $data['district'];
        $user->is_baptisted = $data['is_baptisted'];
        $user->baptist_date = $data['baptist_date'];
        $user->baptist_place = $data['baptist_place'];
        $user->language = $data['language'];
        $user->profession_id = $data['profession_id'];
	    // $user->profession = $data['profession'];
        // $user->ceb = $data['ceb'];
        // $user->group = $data['group'];
        // $user->post = $data['post'];
        $user->tel = $data['tel'];
        $user->is_married = $data['is_married'];
        $user->save();
        
        return response()->json($user);
    }

    public function find($id)
    {
        if (!$user = User::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        return response()->json($user);
    }

    public function update(Request $req, $id)
    {
        $user = User::find($id);
        if (!$user) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_NOT_FOUND");
            return response()->json($apiError, 404);
        }

        $data = $req->except('files');

        // $this->validate($data, [
        //     'first_name' => 'required|min:2',
        //     'last_name' => 'required|min:2',
        //     // 'password' => 'required|min:4',
        //     // 'email' => ['required', 'email'],
        //     'user_type' => 'required',
        // ]);

        if (isset($data['password']) && strlen($data['password']) >= 4) {
            $data['password'] = bcrypt($data['password']);
        }

        //upload image
        if ($file = $req->file('files')) {
            $filePaths = $this->saveSingleImage($this, $req, 'files', 'users');
            $data['avatar'] = json_encode(['images' => $filePaths]);
        }

        if (isset($data['login'])) $user->login = $data['login'];
        if (isset($data['email'])) $user->email = $data['email'];
        if (isset($data['password'])) $user->password = $data['password'];
        if (isset($data['gender'])) $user->gender = $data['gender'];
        if (isset($data['first_name'])) $user->first_name = $data['first_name'];
        if (isset($data['last_name'])) $user->last_name = $data['last_name'];
        if (isset($data['birth_date'])) $user->birth_date = $data['birth_date'];
        if (isset($data['birth_place'])) $user->birth_place = $data['birth_place'];
        if (isset($data['avatar'])) $user->avatar = $data['avatar'];
        if (isset($data['baptist_date'])) $user->baptist_date = $data['baptist_date'];
        if (isset($data['profession_id'])) $user->profession_id = $data['profession_id'];
        if (isset($data['is_married'])) $user->is_married = $data['is_married'];
        if (isset($data['district'])) $user->district = $data['district'];
        if (isset($data['tel'])) $user->tel = $data['tel'];
        if (isset($data['language'])) $user->language = $data['language'];
        if (isset($data['ceb'])) $user->ceb = $data['ceb'];
        if (isset($data['group'])) $user->group = $data['group'];
        if (isset($data['post'])) $user->post = $data['post'];

        $user->update();

        return response()->json($user);
    }

    public function destroy($id)
    {
        if (!$user = User::find($id)) {
            $apiError = new APIError;
            $apiError->setStatus("404");
            $apiError->setCode("USER_NOT_FOUND");
            return response()->json($apiError, 404);
        }
        $user->delete();

        return response()->json();
    }
}
