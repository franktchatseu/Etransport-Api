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
        $user->login = 'Innvotrans';
        $user->password = bcrypt('transport@2020');
        $user->first_name = 'e-transport';
        $user->last_name = 'New';
        $user->save();
    }
}
