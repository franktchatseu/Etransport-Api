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
        // ['PRIEST', 'CATECHIST', 'CATECHUMEN', 'PARISHIONER', 'OTHER', 'PARISHIONER', 'ASSOCIATION_MANAGER', 'CATHECHESIS_COORDINATOR', 'PARISHIONER_SECRETARY',]
        $parishional = new Utype();
        $parishional->value = 'PARISHIONER';
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

        // 'ASSOCIATION_MANAGER', 'CATHECHESIS_COORDINATOR', 'PARISHIONER_SECRETARY',
        $associationManager = new Utype();
        $associationManager->value = 'ASSOCIATION_MANAGER';
        $associationManager->save();

        $cathechesisCoordinator = new Utype();
        $cathechesisCoordinator->value = 'CATHECHESIS_COORDINATOR';
        $cathechesisCoordinator->save();

        $parishionerSecretary = new Utype();
        $parishionerSecretary->value = 'PARISHIONER_SECRETARY';
        $parishionerSecretary->save();

        // $other = new Utype();
        // $other->value = 'OTHER';
        // $other->save();
    }
}
