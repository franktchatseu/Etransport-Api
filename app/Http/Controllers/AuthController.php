<?php

namespace App\Http\Controllers;

use DB;
use App\Models\APIError;
use App\Models\Person\Role;
use App\Models\Person\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use \Carbon\Carbon;
use App\Models\Person\Parishional;
use App\Models\person\Priest;
use App\Models\Person\Cathechumene;
use App\Models\Person\Catechist;

class AuthController extends Controller
{
    private static $tokenName = 'GP Personal Access Token';


    /**
     * Login the user with email and password
     */
    public function login(Request $req)
    {
        $this->validate($req->all(), [
            'login' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($req->only('login', 'password'))) {
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();
            $tokenResult = $user->createToken(self::$tokenName);
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addDay();
            if (null != $req->remember_me) {
                $token->expires_at = Carbon::now()->addMonth();
            }
            $token->save();

            // who really
            if ($user->user_type == 'PARISHIONER') {
                // find permissions
                $user->parishional = Parishional::where(['user_id' => $user->id])->first();
            }

            if ($user->user_type == 'PRIEST') {
                // find permissions
                $user->priest = Priest::where(['user_id' => $user->id])->first();
            }

            if ($user->user_type == 'CATECHIST') {
                // find permissions
                $user->catechist = Catechist::where(['user_id' => $user->id])->first();
            }

            if ($user->user_type == 'CATECHUMEN') {
                // find permissions
                $user->catechumene = Cathechumene::where(['user_id' => $user->id])->first();
            }

            return response()->json([
                'token' => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
                ],
                'user' => $user,
                'roles' => $user->roles,
                'permissions' => $user->allPermissions()
            ]);
        } else {
            $unauthorized = new APIError;
            $unauthorized->setStatus("401");
            $unauthorized->setCode("AUTH_LOGIN");
            $unauthorized->setMessage("Incorrect login or password.");

            return response()->json($unauthorized, 401);
        }
    }



    /**
     * Log out current logged user
     */
    public function logout(Request $req)
    {
        if (Auth::check()) {
            $token = $req->user()->token();
            $token->revoke();
        }
        return response(null, 200);
    }



    /**
     * Get the current logged user
     */
    public function user()
    {
        return Auth::user();
    }



    /**
     * Get all permissions of logged user
     */
    public function permissions()
    {
        $user = Auth::user();
        return response()->json($user->allPermissions());
    }


    /**
     * Get all roles of logged user
     */
    public function roles()
    {
        $user = Auth::user();
        return response()->json($user->roles()->get());
    }


    /**
     * Get all teams of logged user
     */
    public function teams()
    {
        $user = Auth::user();
        return response()->json($user->rolesTeams);
    }
}
