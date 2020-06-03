<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\AnnualMember;

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
            $annualMember->save();
        });
    }
}
