<?php

use Illuminate\Database\Seeder;
use App\Models\Planification\Agenda;
use App\Models\Setting\Parish;
class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(Agenda::class, 21)->make()->each(function ($agenda) use ($faker) {
            $parish = Parish::all();
            $agenda->parish_id = $faker->randomElement($parish)->id;;
            $agenda->save();
        });
    }
}
