<?php

namespace App\Models\Person;

use Laratrust\Models\LaratrustTeam;



/**
 * @OA\Schema(
 *  title="Team",
 *  @OA\Property(
 *      property="id",
 *      type="int",
 *      description="Unique ID",
 *      example="1"
 *  ),
 *  @OA\Property(
 *      property="name",
 *      type="string",
 *      description="Unique team name",
 *      example="user"
 *  ),
 *  @OA\Property(
 *      property="display_name",
 *      type="string",
 *      description="Name to display to users",
 *      example="Team of 'Product #1'"
 *  ),
 *  @OA\Property(
 *      property="description",
 *      type="string",
 *      description="Team description",
 *      example="Team for simple user of system, role for mobile's app user"
 *  ),
 *  @OA\Property(
 *      property="created_at",
 *      type="timestamp",
 *      description="Creation date",
 *      example="2019-10-14 12:00:00"
 *  ),
 *  @OA\Property(
 *      property="updated_at",
 *      type="timestamp",
 *      description="Last time entity has been updated",
 *      example="2019-10-14 12:00:00"
 *  )
 * )
 */
class Team extends LaratrustTeam
{
    public $guarded = [];
}
