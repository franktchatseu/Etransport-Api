<?php

use App\Models\Finance\RequestForMass;
use Illuminate\Database\Seeder;

class RequestForMassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(RequestForMass::class, 21)->make()->each(function ($requestForMass) use ($faker) {
            $requestForMass->save();
        });
    }
}
