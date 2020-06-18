<?php

use App\Models\Sanction\Sanction;
use Illuminate\Database\Seeder;

class SanctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Sanction::class, 100)->make()->each(function ($sanction) use ($faker) {
            $type = App\Models\Sanction\PunishmentType::all();
            $sanction->type_id = $faker->randomElement($type)->id;
            $sanction->save();
        });
    }
}
