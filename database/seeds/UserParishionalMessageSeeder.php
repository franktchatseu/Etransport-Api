<?php

use App\Models\Notification\UserParishionalMessage;
use Illuminate\Database\Seeder;

class UserParishionalMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(UserParishionalMessage::class, 20)->make()->each(function ($user_parishional_message) use ($faker) {
            $users = App\Models\Person\User::all();
            $parishional_messages = App\Models\Notification\ParishionalMessages::all();
            $user_parishional_message->user_id = $faker->randomElement($users)->id;
            $user_parishional_message->parishional_message_id = $faker->randomElement($parishional_messages)->id;
            $user_parishional_message->save();
        });
    }
}
