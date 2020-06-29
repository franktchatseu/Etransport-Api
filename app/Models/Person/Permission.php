<?php

namespace App\Models\Person;

use Laratrust\Models\LaratrustPermission;


/**
 * @OA\Schema(
 *  title="Permission",
 *  @OA\Property(
 *      property="id",
 *      type="int",
 *      description="Unique ID",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      property="name",
 *      type="string",
 *      description="Unique Permission name",
 *      example="article-c"
 *  ),
 *  @OA\Property(
 *      property="display_name",
 *      type="string",
 *      description="Name to display",
 *      example="Create article"
 *  ),
 *  @OA\Property(
 *      property="description",
 *      type="string",
 *      description="Permission description",
 *      example="Permission for article creation"
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
class Permission extends LaratrustPermission
{
    protected $guarded = [];
}
