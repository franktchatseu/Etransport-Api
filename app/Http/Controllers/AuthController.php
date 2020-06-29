<?php


namespace App\Http\Controllers;

use DB;
use App\Models\APIError;
use Illuminate\Http\Request;
use Auth;
use \Carbon\Carbon;
use App\Models\Person\Parishional;
use App\Models\Person\UserUtype;

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

            // fetch all type
            $types = UserUtype::select('utypes.id as utype_id', 'utypes.value', 'user_utypes.id', 'parishs.name as parish_name', 'parishs.id as parish_id', 'user_utypes.is_active as parish_is_active')
            ->join('utypes', 'user_utypes.type_id', '=', 'utypes.id')
            ->join('parishs', 'user_utypes.parish_id', '=', 'parishs.id')
            ->where([
                    'user_utypes.user_id' => $user->id, 
                    'user_utypes.is_active' => true
            ])->get();

            $allTypes = [];
            $profiles = [];
            foreach($types as $key => $value) {
                if ( !in_array($value->value, $allTypes) ) {
                    $allTypes[] = $value->value;
                }
                if (in_array($value->value, $allTypes)) {
                    $profiles[strtolower($value->value)] = UserUtype::where(['user_id' => $user->id])->first();
                    $profiles[strtolower($value->value)]['identifiant'] = $value->id;
                    $profiles[strtolower($value->value)]['utype_id'] = $value->utype_id;
                    $profiles[strtolower($value->value)]['parish'] = [
                        'parish_name' => $value->parish_name, 
                        'parish_id'=> $value->parish_id,
                        'parish_is_active' => $value->parish_is_active
                    ];
                }
            }
            
            return response()->json([
                'token' => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
                ],
                'user' => ['infos' => $user, 'profiles' => $profiles, 'types' => $allTypes],
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
