<?php

use App\Models\Sanction\PunishmentType;
use Illuminate\Database\Seeder;

class PunishmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(PunishmentType::class, 100)->make()->each(function ($punishment) use ($faker) {
            $punishment->save();
        });
    }
}
