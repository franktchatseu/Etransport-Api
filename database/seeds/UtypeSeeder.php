<?php

use Illuminate\Database\Seeder;
use App\Models\Person\Utype;

class UtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        // ['PRIEST', 'CATECHIST', 'CATECHUMEN', 'PARISHIONAL', 'OTHER']
        $parishional = new Utype();
        $parishional->value = 'PARISHIONAL';
        $parishional->save();

        $catechumen = new Utype();
        $catechumen->value = 'CATECHUMEN';
        $catechumen->save();

        $catechist = new Utype();
        $catechist->value = 'CATECHIST';
        $catechist->save();

        $priest = new Utype();
        $priest->value = 'PRIEST';
        $priest->save();

        

        // $other = new Utype();
        // $other->value = 'OTHER';
        // $other->save();
    }
}
