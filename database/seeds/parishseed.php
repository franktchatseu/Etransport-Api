<?php

use App\Model\Person\parish;
use Illuminate\Database\Seeder;

class parishseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(parish::class, 21)
        ->make()
        ->each(function ($parish) use ($faker) {
            $parish->save();
        });
    }
}
