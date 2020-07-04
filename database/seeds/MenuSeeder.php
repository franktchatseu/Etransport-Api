<?php

use Illuminate\Database\Seeder;
use App\Models\Actuality\Menu;
use App\Models\Actuality\Sub_Menu;

class MenuSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        $actualities = [
            'sub_menus' => [
                [ 'name' => 'Diocèse', 'slug' => 'diocese'],
                [ 'name' => 'Doyenné', 'slug' => 'doyenne'],
                [ 'name' => 'La paroisse', 'slug' => 'la_paroisse'],
                [ 'name' => 'Nécrologie', 'slug' => 'necrologie'],
                [ 'name' => 'Catéchèse', 'slug' => 'cathechese'],
                [ 'name' => 'Les MACs', 'slug' => 'les_macs'],
                [ 'name' => 'Les CEBs', 'slug' => 'les_cebs'],
                [ 'name' => 'Les Postes', 'slug' => 'les_postes'] 
            ]
        ];

        $menu = new Menu();
        $menu->name = 'Actualités';
        $menu->slug = 'actualites';
        $menu->save();

        foreach($actualities as $key => $values) {
            if ($key === 'sub_menus') {
                foreach ($values as $key => $value) {
                    $object = $value;
                    $object['menu_id'] = $menu->id;
                    $attribute = Sub_Menu::create($object);
                }
            }
        }

        // factory(Menu::class, 50)->make()->each(function($menu) use ($faker) {
        //     $menu->slug = $menu->name;
        //     $menu->save();
        // });
    }
}

