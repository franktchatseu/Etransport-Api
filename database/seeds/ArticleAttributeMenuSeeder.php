<?php

use App\Models\Actuality\Article_Attribute_Menu;
use Illuminate\Database\Seeder;
use App\Models\Actuality\ArticleAttributeMenu;
use App\Models\Actuality\Menu;
use App\Models\Actuality\Sub_Menu;
use App\Models\Actuality\Attribute_Menu;

class ArticleAttributeMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        
        // factory(Article_Attribute_Menu::class, 50)->make()->each(function($articleAttributeMenu) use ($faker) {
            $articles = App\Models\Actuality\Article::all();
            // $attributeMenus = Attribute_Menu::all();
            
            // dump(count($attributeMenus));
            for($i = 0; $i < count($articles); $i++) {
                $article = $articles[$i];
                $attributeMenus = Sub_Menu::select('attribute_menus.id as attribute_menu_id')
                ->join('menus', 'menus.id', '=', 'sub_menus.menu_id')
                ->join('articles', 'articles.sub_menu_id', '=', 'sub_menus.id')
                ->join('attribute_menus', 'attribute_menus.menu_id', '=', 'menus.id')
                ->where('articles.id','=', $article->id)
                ->get();
                foreach ($attributeMenus as $key => $value) {
                    // if ( count(Article_Attribute_Menu::where([ ['article_id', '=', $article->id], ['attribute_menu_id', '=', $value->id]])->get()) == 0 ) {
                    Article_Attribute_Menu::create([
                        'article_id' => $article->id,
                        'attribute_menu_id' => $value->attribute_menu_id,
                        'value' => 'Lorem ipsum dolor'
                    ]);
                    // }
                }
            }
            
           
        // });
    }
}

