<?php

use App\Models\Liturgical\EntryType;
use Illuminate\Database\Seeder;

class EntryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(EntryType::class, 10)->make()->each(function ($entry) use ($faker) {
            $entry->save();
        });
    }
}
