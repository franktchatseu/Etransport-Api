<?php

use App\Models\Actuality\Sub_Menu;
use Illuminate\Database\Seeder;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Sub_Menu::class, 5)->make()->each(function($submenu) use ($faker) {
            $menu = App\Models\Actuality\Menu::all();
            $submenu->menu_id = $faker->randomElement($menu)->id;
            $submenu->save();
        });
    }
}


