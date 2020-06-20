<?php

use Illuminate\Database\Seeder;
use App\Models\Actuality\ArticleAttributeMenu;

class ArticleAttributeMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(ArticleAttributeMenu::class, 50)->make()->each(function($articleAttributeMenu) use ($faker) {
            $articleAttributeMenu->save();
        });
    }
}

