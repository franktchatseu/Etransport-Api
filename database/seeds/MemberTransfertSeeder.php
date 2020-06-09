<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\MemberTransfert;

class MemberTransfertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(MemberTransfert::class, 100)->make()->each(function ($membertransfert) use ($faker) {
            $members = App\Models\Catechesis\Member::all();
            $transferts = App\Models\Catechesis\Transfert::all();
            $membertransfert->member_id = $faker->randomElement($members)->id;
            $membertransfert->transfert_id = $faker->randomElement($transferts)->id;
            $membertransfert->save();
        });
    }
}
