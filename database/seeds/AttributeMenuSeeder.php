<?php

use App\Models\Actuality\Attribute_Menu;
use Illuminate\Database\Seeder;

class AttributeMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Attribute_Menu::class, 20)->make()->each(function($attributemenu) use ($faker) {
            $attribute = App\Models\Actuality\Attribute::all();
            $submenu = App\Models\Actuality\Menu::all();
            $attributemenu->attribute_id = $faker->randomElement($attribute)->id;
            $attributemenu->menu_id = $faker->randomElement($submenu)->id;
            $attributemenu->save();
        });
    }
}

