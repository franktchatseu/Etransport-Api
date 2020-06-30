<?php

use App\Models\Liturgical\LiturgicalType;
use Illuminate\Database\Seeder;

class LiturgicalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(LiturgicalType::class, 2)->make()->each(function ($type) use ($faker) {
            $type->slug = $type->title;
            $type->save();
        });
    }
}
