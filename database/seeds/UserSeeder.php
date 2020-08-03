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
        $user->login = 'administrator';
        $user->password = bcrypt('transport');
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->save();
    }
}
