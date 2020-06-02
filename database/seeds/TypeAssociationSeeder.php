<?php

use App\Models\Association\TypeAssociation;
use Illuminate\Database\Seeder;

class TypeAssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(TypeAssociation::class, 10)->make()->each(function($typeAssociation) use ($faker) {
            $typeAssociation->save();
        });
    }
}
