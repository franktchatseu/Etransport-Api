<?php

use App\Models\Actuality\Article_Attribute_Menu;
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
        
        factory(Article_Attribute_Menu::class, 50)->make()->each(function($articleAttributeMenu) use ($faker) {
            $article = App\Models\Actuality\Article::all();
            $attribute = App\Models\Actuality\Attribute::all();
            $attributemenu = App\Models\Actuality\Attribute_Menu::all();
            $articleAttributeMenu->article_id = $faker->randomElement($article)->id;
            $articleAttributeMenu->attribute_id = $faker->randomElement($attribute)->id;
            $articleAttributeMenu->attribute_menu_id = $faker->randomElement($attributemenu)->id;
            $articleAttributeMenu->save();
        });
    }
}

