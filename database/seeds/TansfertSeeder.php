<?php

use Illuminate\Database\Seeder;
use App\Models\Cathechesis\Transfert;

class TansfertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Transfert::class,100)->make()->each(function($transfert) use ($faker){
            $transfert->save();
        });
    }
}
