<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\Authorization;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Authorization::class, 50)->make()->each(function ($authorization) use ($faker) {
            $authorization->save();
        });
    }
}
