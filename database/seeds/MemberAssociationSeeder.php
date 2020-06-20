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
            $user = App\Models\Person\User::all();
            $statut = App\Models\Association\Statut::all();
            $memberAssociation->user_id = $faker->randomElement($user)->id;
            $memberAssociation->statut_id = $faker->randomElement($statut)->id;
            $memberAssociation->save();
        });
    }
}
