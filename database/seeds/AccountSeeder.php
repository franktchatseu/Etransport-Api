<?php

use Illuminate\Database\Seeder;
use App\Models\Finance\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Account::class, 25)->make()->each(function ($account) use ($faker) {
           // $account_type = App\Models\Finance\AccountType::all();
           // $account->accounttype_id = $faker->randomElement($account_type)->id;
            $account->save();
        });
    }
}
