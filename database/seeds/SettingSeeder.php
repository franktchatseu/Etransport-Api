<?php

use Illuminate\Database\Seeder;
use App\Models\Setting\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Setting::class, 10)->make()->each(function ($setting) use ($faker) {
            $users = App\Models\Person\User::all();
            $setting->user_id = $faker->randomElement($users)->id;
            $setting->save();
        });
    }
}
