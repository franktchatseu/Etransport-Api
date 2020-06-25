<?php

use App\Models\Request\SettingRequest;
use Illuminate\Database\Seeder;

class SettingRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(SettingRequest::class, 100)->make()->each(function ($SettingRequest) use ($faker) {
           $SettingRequest->save();
        });
    }
}
