<?php

use Illuminate\Database\Seeder;
use App\Models\Actuality\Attribute;
use App\Models\Actuality\Select;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Attribute::class, 15)->make()->each(function($attribute) use ($faker) {
            $attribute->slug = $attribute->name;
            $attribute->save();
        });

        factory(Select::class, 30)->make()->each(function($select) use ($faker) {
            $attributes = Attribute::all();
            $attr = $faker->randomElement($attributes);
            if ($attr->type == 'select') {
                $select->attribute_id = $attr->id;
                $select->save();
            }
        });
    }
}

  