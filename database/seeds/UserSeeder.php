<?php

use App\Models\Person\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->login = 'Innovtrans';
        $user->password = bcrypt('transport@2020');
        $user->first_name = 'e-transport';
        $user->last_name = 'New';
        $user->save();
        
        
        $user1 = new User();
        $user1->login = 'AdamShan';
        $user1->password = bcrypt('adadjufa@2020');
        $user1->first_name = 'Adamu';
        $user1->last_name = 'Aliyu';
        $user1->save();
    
        $user2 = new User();
        $user2->login = 'Frank';
        $user2->password = bcrypt('ubuntu');
        $user2->first_name = 'Tchatseu';
        $user2->last_name = 'Frank';
        $user2->save();
    
        $user3 = new User();
        $user3->login = 'Franklin';
        $user3->password = bcrypt('transport@2020');
        $user3->first_name = 'Tanemou';
        $user3->last_name = 'Franklin';
        $user3->save();
    }
}
