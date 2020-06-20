<?php

use App\Models\Association\EventPresenceMemberAssociation;
use Illuminate\Database\Seeder;

class EventPresenceMemberAssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(EventPresenceMemberAssociation::class, 21)->make()->each(function ($presence) use ($faker) {
            $event = App\Models\Association\Evenement::all();
            $member = App\Models\Association\MemberAssociation::all();
            $presence->evenement_id = $faker->randomElement($event)->id;
            $presence->member_association_id = $faker->randomElement($member)->id;
            $presence->save();
        });
    }
}
