<?php

use Illuminate\Database\Seeder;
use App\Models\Actuality\AttributeMenu;

class AttributeMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(AttributeMenu::class, 50)->make()->each(function($attributemenu) use ($faker) {
            $attributemenu->save();
        });
    }
}

