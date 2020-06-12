<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\AnnualmemberAuthorization;

class AnnualmemberAuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(AnnualmemberAuthorization::class, 100)->make()->each(function ($annualmemberauthorization) use ($faker) {
            $annualmembers = App\Models\Catechesis\AnnualMember::all();
            $authorizations = App\Models\Catechesis\Authorization::all();
            $annualmemberauthorization->annualmember_id = $faker->randomElement($annualmembers)->id;
            $annualmemberauthorization->authorization_id = $faker->randomElement($authorizations)->id;
            $annualmemberauthorization->save();
        });
    }
}
