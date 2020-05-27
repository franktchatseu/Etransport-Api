<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Schema::disableForeignKeyConstraints();

        $this->call(SettingSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(MassSheduleSeeder::class);

        Schema::enableForeignKeyConstraints();
        Model::reguard();
    }
}
