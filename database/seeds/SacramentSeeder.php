<?php

use App\Models\Sacrament\Sacrament;
use Illuminate\Database\Seeder;

class SacramentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Sacrament::class, 100)->make()->each(function ($sacrament) use ($faker) {
            $category = App\Models\Sacrament\SacramentCategorie::all();
            $sacrament->category_id = $faker->randomElement($category)->id;
            $sacrament->save();
        });
    }
}
