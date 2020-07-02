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
     * @OA\Post(
     *     path="/auth/token",
     *     tags={"auth"},
     *     summary="Login user",
     *     description="Login the user with email and password",
     *     operationId="AuthController@login",
     *     @OA\Parameter(
     *          name="email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="<pre>
     *          {
     *              user: User,
     *              roles: Role,
     *              permissions: Permission,
     *              token: {
     *                  access_token: string,
     *                  token_type:  'Bearer'
     *                  expires_at:   string
     *              }
     *          }
     *          </pre>",
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="ERR_01: Tous les champs sont requis",
     *          @OA\JsonContent(ref="#/components/schemas/APIError")
     *      ),
     *      @OA\Response(
     *         response=401,
     *         description="<pre>
     *                      AUTH_LOGIN: Login ou mot de passe incorrect.
     *                  </pre>",
     *         @OA\JsonContent(ref="#/components/schemas/APIError")
     *      )
     * )
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
     * @OA\Delete(
     *     path="/auth/token",
     *     tags={"auth"},
     *     summary="Logs out current logged",
     *     operationId="AuthController@logout",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized.",
     *         @OA\JsonContent(ref="#/components/schemas/APIError")
     *      ),
     *     security={{"api_key": {}}}
     * )
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
     * @OA\Get(
     *     path="/auth/user",
     *     tags={"auth"},
     *     summary="Get the current logged user",
     *     operationId="AuthController@user",
     *     @OA\Response(
     *         response=200,
     *         description="Return User model",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized.",
     *         @OA\JsonContent(ref="#/components/schemas/APIError")
     *      ),
     *     security={{"api_key": {}}}
     * )
     */
    public function user()
    {
        return Auth::user();
    }



    /**
     * @OA\Get(
     *     path="/auth/permissions",
     *     tags={"auth"},
     *     summary="Get all permission of logged user",
     *     operationId="AuthController@permissions",
     *     @OA\Response(
     *         response=200,
     *         description="json array of permission: Permission[]",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Permission")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized.",
     *         @OA\JsonContent(ref="#/components/schemas/APIError")
     *      ),
     *     security={{"api_key": {}}}
     * )
     */
    public function permissions()
    {
        $user = Auth::user();
        return response()->json($user->allPermissions());
    }



    /**
     * @OA\Get(
     *     path="/auth/roles",
     *     tags={"auth"},
     *     summary="Get all roles of logged user",
     *     operationId="AuthController@roles",
     *     @OA\Response(
     *         response=200,
     *         description="json array of role: Role[]",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Role")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="AUTH_00: Unauthorized.",
     *         @OA\JsonContent(ref="#/components/schemas/APIError")
     *      ),
     *     security={{"api_key": {}}}
     * )
     */
    public function roles()
    {
        $user = Auth::user();
        return response()->json($user->roles()->get());
    }


    /**
     * @OA\Get(
     *     path="/auth/teams",
     *     tags={"auth"},
     *     summary="Get all team of logged user",
     *     operationId="AuthController@teams",
     *     @OA\Response(
     *         response=200,
     *         description="json array of role: Team[]",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Team")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="AUTH_00: Unauthorized.",
     *         @OA\JsonContent(ref="#/components/schemas/APIError")
     *      ),
     *     security={{"api_key": {}}}
     * )
     */
    public function teams()
    {
        $user = Auth::user();
        return response()->json($user->rolesTeams);
    }
}
