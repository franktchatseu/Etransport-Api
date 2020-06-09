<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Person\User;
use App\Models\person\Priest;
use App\Models\Person\Parishional;

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
            // 'login' => ['required', Rule::unique('users', 'login')],
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'district' => 'required',
            // 'password' => 'required|min:4',
	     //   'profession_id' => ['required', 'exists:professions,id'],
	    'profession' => ['required'],
            // 'email' => ['required', 'email', Rule::unique('users', 'email')],
        ]);

        $data['avatar'] = '';
        //upload image
        if ($file = $req->file('files')) {
            /* $filePaths = $this->uploadMultipleFiles($req, 'files', 'users', ['file', 'mimes:jpg,png,gif']); */
                $extension = $file->getClientOriginalExtension();
                $relativeDestination = "uploads/users";
                $destinationPath = public_path($relativeDestination);
                $safeName = "document".time().'.'.$extension;
                $file->move($destinationPath, $safeName);
                $path = "$relativeDestination/$safeName";
            	$data['avatar'] = json_encode($path);
        }

        
        $user = new User();
        // $user->login = $data['login'];
        $user->email = $data['email'];
        // $user->password = bcrypt($data['password']);
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
        // $user->profession_id = $data['profession_id'];
	$user->profession = $data['profession'];
        $user->ceb = $data['ceb'];
        $user->group = $data['group'];
        $user->post = $data['post'];
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

        $type = Priest::where('user_id', $id)->first()
            ?? Parishional::where('user_id', $user->id)->first();

        $user['type'] = $type;

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

        $this->validate($data, [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'password' => 'required|min:4',
            'email' => ['required', 'email'],
            'user_type' => 'required',
        ]);

        if (isset($data['password']) && strlen($data['password']) >= 4) {
            $data['password'] = bcrypt($data['password']);
        }

        //upload image
        if ($file = $req->file('files')) {
            $filePaths = $this->uploadMultipleFiles($req, 'files', 'users', ['file', 'mimes:jpg,png,gif']);
            $data['avatar'] = json_encode($filePaths);
        }

        if (null !== $data['login']) $user->login = $data['login'];
        if (null !== $data['email']) $user->email = $data['email'];
        if (null !== $data['password']) $user->password = $data['password'];
        if (null !== $data['gender']) $user->gender = $data['gender'];
        if (null !== $data['first_name']) $user->first_name = $data['first_name'];
        if (null !== $data['last_name']) $user->last_name = $data['last_name'];
        if (null !== $data['birth_date']) $user->birth_date = $data['birth_date'];
        if (null !== $data['birth_place']) $user->birth_place = $data['birth_place'];
        if (null !== $data['avatar']) $user->avatar = $data['avatar'];
        if (null !== $data['baptist_date']) $user->baptist_date = $data['baptist_date'];
        if (null !== $data['state']) $user->state = $data['state'];
        if (null !== $data['tel']) $user->tel = $data['tel'];
        if (null !== $data['user_type']) $user->user_type = $data['user_type'];

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
