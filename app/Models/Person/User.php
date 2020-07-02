<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use DB;


/**
 * @OA\Schema(
 *  title="User",
 *  required={"first_name", "password", "email", "is_citizen", "category_id"},
 *  @OA\Property(
 *      property="id",
 *      type="int",
 *      description="Unique ID",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      property="first_name",
 *      type="string",
 *      description="User's first name",
 *      example="John"
 *  ),
 *  @OA\Property(
 *      property="last_name",
 *      type="string",
 *      description="User's last name",
 *      example="Doe"
 *  ),
 *  @OA\Property(
 *      property="email",
 *      type="string",
 *      description="E-mail address",
 *      example="johndoe@gmail.com"
 *  ),
 *  @OA\Property(
 *      property="tel",
 *      type="string",
 *      description="Phone number",
 *      example="+237673173481"
 *  ),
 *  @OA\Property(
 *      property="last_login",
 *      type="timestamp",
 *      description="User's last login date. <b style='color:red;'>readonly</b>",
 *      example="2019-10-14 12:00:00"
 *  ),
 *  @OA\Property(
 *      property="expired_at",
 *      type="timestamp",
 *      description="User's account expiration date",
 *      example="2019-10-14 12:00:00"
 *  ),
 *  @OA\Property(
 *      property="password",
 *      type="string",
 *      description="User's password",
 *      example="******"
 *  ),
 *  @OA\Property(
 *      property="avatar",
 *      type="string",
 *      description="User's url picture",
 *      example="http://localhost:8000/uploads/users/exampl.jpg"
 *  ),
 *  @OA\Property(
 *      property="created_at",
 *      type="timestamp",
 *      description="User's creation date <b style='color:red;'>readonly</b>",
 *      example="2019-10-14 12:00:00"
 *  ),
 *  @OA\Property(
 *      property="updated_at",
 *      type="timestamp",
 *      description="Last time user has been updated <b style='color:red;'>readonly</b>",
 *      example="2019-10-14 12:00:00"
 *  )
 * )
 */
class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use HasApiTokens;
    use SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at'
    ];


    /**
     *  Get query of permitted model for user
     * @param string $model the full model class name
     * @param string|array $permissions single permission or array of permission
     * @param string $keyColumn key column to match with team's name
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function getPermittedInstances(string $model, $permissions, string $keyColumn = 'slug')
    {
        if ($permissions instanceof string) {
            $permissions = [$permissions];
        }
        $teamIds1 = DB::table('role_user')->where('user_id', $this->id)->pluck('team_id')->toArray();
        $teamIds2 = DB::table('permission_user')->where('user_id', $this->id)->pluck('team_id')->toArray();
        $teamIds = array_merge($teamIds1, $teamIds2);
        $teamNames = Team::whereIn('id', array_unique($teamIds))->pluck('name');

        $tableName = eval('return (new ' . $model . ')->getTable();');

        $slugs = []; // Team name are also product slug
        foreach ($teamNames as $teamName) {
            if ($this->isAbleTo($permissions, $teamName, true)) {
                $slugs[] = str_replace("$tableName-", '', $teamName);
            }
        }

        return eval('return ' . $model . '::whereIn($keyColumn, $slugs);');
    }


    function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'getPermitted')) {
            $model = 'App\\Models\\' . str_replace('getPermitted', '', $method);
            return $this->getPermittedInstances($model, ...$parameters);
        }

        return parent::__call($method, $parameters);
    }

    public function parishionalMessages() {
        return $this->belongsToMany('App\Models\Notification\ParishionalMessages', 'user_parishional_message', 'user_id', 'parishional_message_id');
    }
}
