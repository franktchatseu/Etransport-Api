<?php

use Illuminate\Database\Seeder;
use App\Models\Actuality\SubMenu;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(SubMenu::class, 50)->make()->each(function($submenu) use ($faker) {
            $submenu->save();
        });
    }
}


