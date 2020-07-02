<?php

use Illuminate\Database\Seeder;
use App\Models\Setting\Parish_theme;
use App\Models\Setting\Parish;
class Parish_themeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(Parish_theme::class, 21)->make()->each(function ($parishtheme) use ($faker) {
            $parish = Parish::all();
            $parishtheme->parish_id = $faker->randomElement($parish)->id;
            $parishtheme->save();
        });
    }
}
