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
        //
        factory(Article::class, 50)->make()->each(function($article) use ($faker) {
            $article->save();
        });
    }
}

