<?php

use Illuminate\Database\Seeder;
use App\Models\Planification\Time;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Time::class, 100)->make()->each(function($time) use ($faker) {
            $time->save();
        });

    }
}
