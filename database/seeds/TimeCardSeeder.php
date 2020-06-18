<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\TimeCard;

class TimeCardSeeder extends Seeder      
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(TimeCard::class, 10)->make()->each(function ($timecard) use ($faker) {
            $timecard->save();
        });
    }
}
