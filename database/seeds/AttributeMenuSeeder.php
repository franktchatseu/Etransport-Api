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
            $attributes = App\Models\Actuality\Attribute::all();
            $menus = App\Models\Actuality\Menu::all();
            $attribute = $faker->randomElement($attributes);
            $menu = $faker->randomElement($menus);
            if ( count(Attribute_Menu::where([['attribute_id', '=', $attribute->id], ['menu_id', '=', $menu->id]])->get()) == 0)
            {
                $attributemenu->attribute_id = $attribute->id;
                $attributemenu->menu_id = $menu->id;
                $attributemenu->save();
            }    
        });
    }
}

