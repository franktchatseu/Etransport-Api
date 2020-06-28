<?php

use App\Models\Liturgical\LiturgicalTypeEntryType;
use Illuminate\Database\Seeder;

class LiturgicalTypeEntryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(LiturgicalTypeEntryType::class, 10)->make()->each(function ($typeentry) use ($faker) {
            $type = \App\Models\Liturgical\LiturgicalType::all();
            $entry = \App\Models\Liturgical\EntryType::all();
            $typeentry->type_id = $faker->randomElement($type)->id;
            $typeentry->entry_type_id = $faker->randomElement($entry)->id;
            $typeentry->save();
        });
    }
}
