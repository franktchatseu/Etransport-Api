<?php

use Illuminate\Database\Seeder;
use App\Models\Request\ObjectRequestMass;

class ObjectRequestMassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(ObjectRequestMass::class, 100)->make()->each(function ($objectrequestmass) use ($faker) {
            $objectrequestmass->save();
        });
    }
}
