<?php

use Illuminate\Database\Seeder;
use App\Models\Messagerie\ChatMessageGroup;

class ChatMessageGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(ChatMessageGroup::class, 300)->make()->each(function ($chat) use ($faker) {
            $members = \App\Models\Messagerie\ChatMemberGroup::all();
            $groups = \App\Models\Messagerie\ChatGroup::all();
            $chat->sender_id = $faker->randomElement($members)->id;
            $chat->group_id = $faker->randomElement($groups)->id;
            $chat->save();
        });
    }
}
