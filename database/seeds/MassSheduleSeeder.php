<?php

use Illuminate\Database\Seeder;
use App\Models\Setting\MassShedule;

class MassSheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function  run(\Faker\Generator $faker)
    {
        factory(MassShedule::class, 21)->make()->each(function ($massShedule) use ($faker) {
            $massShedule->save();
        });
    }
}
