<?php

use Illuminate\Database\Seeder;
use App\Models\Setting\ParishPatrimony;

class ParishPatrimonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator$faker)
    {
        factory(ParishPatrimony::class, 10)->make()->each(function($parishPatrimony) use ($faker){
            $parishs = App\Models\Setting\Parish::all();
            $parishPatrimony->parish_id = $faker->randomElement($parishs)->id;
            $parishPatrimony->save();
        });
    }
}
