<?php

use Illuminate\Database\Seeder;
use App\Models\Finance\Input;

class InputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Input::class, 50)->make()->each(function ($inputs) use ($faker) {
            $inputs->save();
        });
    }
}
