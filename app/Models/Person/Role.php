<?php

namespace App\Models\Person;

use Laratrust\Models\LaratrustRole;


/**
 * @OA\Schema(
 *  title="Role",
 *  @OA\Property(
 *      property="id",
 *      type="int",
 *      description="Unique ID",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      property="name",
 *      type="string",
 *      description="Unique role name",
 *      example="user"
 *  ),
 *  @OA\Property(
 *      property="display_name",
 *      type="string",
 *      description="Name to display to users",
 *      example="Simple user role"
 *  ),
 *  @OA\Property(
 *      property="description",
 *      type="string",
 *      description="Role description",
 *      example="Role for simple user of system, role for mobile's app user"
 *  ),
 *  @OA\Property(
 *      property="created_at",
 *      type="timestamp",
 *      description="Creation date <b style='color:red;'>readonly</b>",
 *      example="2019-10-14 12:00:00"
 *  ),
 *  @OA\Property(
 *      property="updated_at",
 *      type="timestamp",
 *      description="Last time entity has been updated <b style='color:red;'>readonly</b>",
 *      example="2019-10-14 12:00:00"
 *  )
 * )
 */
class Role extends LaratrustRole
{
    protected $guarded = [];

    public function permissions() {
        return $this->belongsToMany('App\Models\Person\Permission');
    }

    // public function permission_roles() {
    //     return $this->belongsToMany('App\PermissionRole');
    // }
}
