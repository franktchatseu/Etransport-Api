<?php

use Illuminate\Database\Seeder;
use App\Models\Actuality\Attribute;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(Attribute::class, 50)->make()->each(function($attribute) use ($faker) {
            $attribute->save();
        });
    }
}

  