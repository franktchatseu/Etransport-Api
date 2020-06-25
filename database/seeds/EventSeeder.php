<?php

use Illuminate\Database\Seeder;
use App\Models\Association\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Event::class, 100)->make()->each(function ($event) use ($faker) {
            $event->save();
        });
    }
    
}

