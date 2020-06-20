<?php

use Illuminate\Database\Seeder;
use App\Models\Request\IntentionMass;

class IntentionMassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(IntentionMass::class, 100)->make()->each(function ($intentionMass) use ($faker) {
            $intentionMass->save();
        });
    }
}
