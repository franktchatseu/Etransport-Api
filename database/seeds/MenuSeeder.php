<?php

use Illuminate\Database\Seeder;
use App\Models\Actuality\Menu;

class MenuSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(Menu::class, 50)->make()->each(function($menu) use ($faker) {
            $menu->save();
        });
    }
}

