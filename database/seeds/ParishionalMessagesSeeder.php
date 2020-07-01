<?php

use App\Models\Notification\ParishionalMessages;
use Illuminate\Database\Seeder;

class ParishionalMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(ParishionalMessages::class, 20)->make()->each(function ($parishional_message) use ($faker) {
            $parishional_message->save();
        });
    }
}
