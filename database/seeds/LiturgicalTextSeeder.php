<?php

use App\Models\Liturgical\LiturgicalText;
use Illuminate\Database\Seeder;

class LiturgicalTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(LiturgicalText::class, 10)->make()->each(function ($typeentry) use ($faker) {
            $type = \App\Models\Liturgical\LiturgicalType::all();
            $typeentry->type_entry_type_id = $faker->randomElement($type)->id;
            $typeentry->save();
        });
    }
}
