<?php

use App\Models\Planification\AssociationPlanning;
use Illuminate\Database\Seeder;

class AssociationPlaningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(AssociationPlanning::class, 100)->make()->each(function ($associationplanning) use ($faker) {
            $association = App\Models\Association\Association::all();
            $planing = App\Models\Planification\Planing::all();
            $associationplanning->association_id = $faker->randomElement($association)->id;
            $associationplanning->planing_id = $faker->randomElement($planing)->id;
            $associationplanning->save();
        });
    }
}
