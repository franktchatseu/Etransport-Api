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
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'password' => 'required|min:4',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'user_type' => 'required',
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['avatar'] = '';
        //upload image
        if ($file = $req->file('files')) {
            $filePaths = $this->uploadMultipleFiles($req, 'files', 'users', ['file', 'mimes:jpg,png,gif']);
            $data['avatar'] = json_encode($filePaths);
        }

        if ($req->has('user_type')) {
            $user = new User();
            $user->login = $data['login'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->avatar = $data['avatar'];
            // $user->email_verified_at = null;
            $user->gender = $data['gender'];
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->birth_date = $data['birth_date'];
            $user->birth_place = $data['birth_place'];
            $user->baptist_date = $data['baptist_date'];
            $user->baptist_place = $data['baptist_place'];
            $user->state = $data['state'];
            $user->user_type = $data['user_type'];
            $user->save();

            // $data['user_id'] = $user->id;
            // if ($data['user_type'] == 'student') {
            //     $student = new Student();
            //     $student->level = $data['level'];
            //     $student->user_id = $data['user_id'];
            //     $student->save();
            //     $user[$data['user_type']] = $student;
            // } else if ($data['user_type'] == 'teacher') {
            //     $teacher = new Teacher();
            //     $teacher->grade = $data['grade'];
            //     $teacher->user_id = $data['user_id'];
            //     $teacher->save();
            //     $user[$data['user_type']] = $teacher;
            // }
        }
        return response()->json($user);
    }

    public function find($id)
    {
        if (!$user = User::find($id)) {
            abort(404, "No user found with id $id");
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
            abort(404, "No user found with id $id");
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
            abort(404, "No user found with id $id");
        }
        $user->delete();

        return response()->json();
    }
}
