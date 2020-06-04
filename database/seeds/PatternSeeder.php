<?php

use App\Models\Catechesis\Pattern;
use Illuminate\Database\Seeder;

class PatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Pattern::class, 21)->make()->each(function ($pattern) use ($faker) {
            $pattern->save();
        });
    }
}
