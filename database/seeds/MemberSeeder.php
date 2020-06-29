<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\Member;
use App\Models\Catechesis\Quarter_Trimestre;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Member::class, 100)->make()->each(function ($member) use ($faker) {
            $user_utypes = \App\Models\Person\UserUtype::all();
            $member->user_utype_id = $faker->randomElement($user_utypes)->id;
            $member->save();
        });
    }
}
