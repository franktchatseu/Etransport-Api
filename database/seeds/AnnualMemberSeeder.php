<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\AnnualMember;
use App\Models\Catechesis\Quarter;

class AnnualMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run(\Faker\Generator $faker)
    {
        factory(AnnualMember::class, 100)->make()->each(function ($annualMember) use ($faker) {
            $quarters = App\Models\Catechesis\Quarter::all();
            $member = App\Models\Catechesis\Member::all();
            $annualMember->member_id = $faker->randomElement($member)->id;
            $annualMember->quarter_id = $faker->randomElement($quarters)->id;
           $annualMember->save();
       });
    }
}
