<?php

use Illuminate\Database\Seeder;
use App\Models\Messagerie\ChatGroup;

class ChatGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(ChatGroup::class, 60)->make()->each(function ($chat) use ($faker) {
            // $userutypes = \App\Models\Person\UserUtype::all();
            // $chat->sender_id = $faker->randomElement($userutypes)->id;
            $chat->save();
        });
    }
}
