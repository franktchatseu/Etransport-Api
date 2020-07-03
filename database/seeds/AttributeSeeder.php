<?php

use Illuminate\Database\Seeder;
use App\Models\Actuality\Attribute;
use App\Models\Actuality\Select;
use App\Models\Actuality\Menu;
use App\Models\Actuality\Attribute_Menu;
use App\Models\Actuality\Sub_Menu;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        // factory(Attribute::class, 15)->make()->each(function($attribute) use ($faker) {
        //     $attribute->slug = $attribute->name;
        //     $attribute->save();
        // preg_replace('/[^a-zA-Z0-9_.]/', '', $request->name)
        // });
        $actualities = [
                'attributes' => [
                    [
                        'name' => 'photo',
                        'type' => 'file',
                        'slug' => 'photo',
                    ],
                    [
                        'name' => 'titre',
                        'type' => 'text',
                        'slug' => 'titre',
                    ],
                    [
                        'name' => 'date de publication',
                        'type' => 'date',
                        'slug' => 'date_de_publication',
                    ],
                    [
                        'name' => 'contenu 1',
                        'type' => 'textarea',
                        'slug' => 'contenu_1',
                    ],
                    [
                        'name' => 'contenu 2',
                        'type' => 'textarea',
                        'slug' => 'contenu_2',
                    ],
                    [
                        'name' => 'fichier',
                        'type' => 'file',
                        'slug' => 'fichier',
                    ]
                ], 
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
            if ($key === 'attributes') {
                foreach ($values as $key => $value) {
                   $attribute = Attribute::create($value);
                   $assoc = Attribute_Menu::create([
                        'attribute_id' => $attribute->id,
                        'menu_id' => $menu->id,
                        'is_required' =>  0,
                        'min_length' =>  10,
                        'max_length' =>  100,   
                   ]);
                }
            }

            if ($key === 'sub_menus') {
                foreach ($values as $key => $value) {
                    $object = $value;
                    $object['menu_id'] = $menu->id;
                    $attribute = Sub_Menu::create($object);
                 }
            }
        }

        // factory(Select::class, 30)->make()->each(function($select) use ($faker) {
        //     $attributes = Attribute::all();
        //     $attr = $faker->randomElement($attributes);
        //     if ($attr->type == 'select') {
        //         $select->attribute_id = $attr->id;
        //         $select->save();
        //     }
        // });
    }
}

  