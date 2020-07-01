<?php

use App\Models\Association\MemberAssociation;
use Illuminate\Database\Seeder;

class MemberAssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(MemberAssociation::class, 21)->make()->each(function ($memberAssociation) use ($faker) {
            $user_utype = \App\Models\Person\UserUtype::all();
            $statut = App\Models\Association\Statut::all();
            $assoc = App\Models\Association\Association::all();
            $memberAssociation->user_utype_id = $faker->randomElement($user_utype)->id;
            $memberAssociation->statut_id = $faker->randomElement($statut)->id;
            $memberAssociation->association_id = $faker->randomElement($assoc)->id;
            $memberAssociation->save();
        });
    }
}
