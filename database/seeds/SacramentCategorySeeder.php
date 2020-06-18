<?php

use App\Models\Sacrament\SacramentCategorie;
use Illuminate\Database\Seeder;

class SacramentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(SacramentCategorie::class, 100)->make()->each(function ($category) use ($faker) {
            $category->save();
        });
    }
}
