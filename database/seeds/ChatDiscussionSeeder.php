<?php

use Illuminate\Database\Seeder;
use App\Models\Messagerie\ChatDiscussion;

class ChatDiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(ChatDiscussion::class, 100)->make()->each(function ($user) use ($faker) {
            $users = \App\Models\Person\UserUtype::all();
            $user1 = $faker->randomElement($users);
            $user2 = $faker->randomElement($users);
            while($user1->id == $user2->id && count(ChatDiscussion::where([
                ['user_utype1_id', $user1->id],
                ['user_utype2_id', $user2->id]
            ])->get()) > 0 ) {
                $user1 = $faker->randomElement($users);
                $user2 = $faker->randomElement($users);
            }
            $user->user_utype1_id = $user1->id;
            $user->user_utype2_id = $user2->id;
            $user->save();
        });
    }
}
