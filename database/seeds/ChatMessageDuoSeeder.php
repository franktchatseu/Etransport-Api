<?php

use Illuminate\Database\Seeder;
use App\Models\Messagerie\ChatMessageDuo;

class ChatMessageDuoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(ChatMessageDuo::class, 200)->make()->each(function ($chat) use ($faker) {
            $discussions = \App\Models\Messagerie\ChatDiscussion::all();
            $rand_sender = $faker->randomElement([0,1]);
            $sender = $faker->randomElement($discussions);
            $chat->sender_id = $rand_sender == 0 ? $sender->user_utype1_id : $sender->user_utype2_id;
            $chat->chat_discussion_id = $sender->id;
            $chat->save();
        });
    }
}
