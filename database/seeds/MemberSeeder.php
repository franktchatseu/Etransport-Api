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
            $users = App\Models\Person\User::all();
            $member->user_id = $faker->randomElement($users)->id;
            $member->save();
        });
    }
}
