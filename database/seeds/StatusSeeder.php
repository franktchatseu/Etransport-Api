<?php

use Illuminate\Database\Seeder;
use App\Models\Association\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Status::class, 100)->make()->each(function ($event) use ($faker) {
            $event->save();
        });
    }}

