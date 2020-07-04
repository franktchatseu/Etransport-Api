<?php

use Illuminate\Database\Seeder;
use App\Models\Actuality\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Article::class, 100)->make()->each(function($article) use ($faker) {
            $user = App\Models\Person\User::all();
            $submenu = App\Models\Actuality\Sub_Menu::all();
            $article->user_id = $faker->randomElement($user)->id;
            $article->sub_menu_id = $faker->randomElement($submenu)->id;
            $article->save();
        });
    }
}

