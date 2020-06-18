<?php

use Illuminate\Database\Seeder;
use App\Models\Messagerie\ChatMemberGroup;

class ChatMemberGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(ChatMemberGroup::class, 70)->make()->each(function ($chat) use ($faker) {
            $groupes = \App\Models\Messagerie\ChatGroup::all();
            $user_types = \App\Models\Person\UserUtype::all();
            $chat->chat_group_id = $faker->randomElement($groupes)->id;
            $chat->user_utype_id = $faker->randomElement($user_types)->id;
            $chat->save();
        });
    }
}
