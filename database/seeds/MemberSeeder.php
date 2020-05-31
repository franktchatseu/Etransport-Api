<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\Member;

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
            $member->save();
        });
    }
}