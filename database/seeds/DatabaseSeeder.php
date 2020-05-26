<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

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

        // $this->call(CityAndCountrySeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(LaratrustSeeder::class);

        // module person
        $this->call([
            ProfessionsSeeder::class,
            PriestSeeder::class,
            AlbumSeeder::class,
            ParishionalSeeder::class,
            ParishSeeder::class
        ]);
        
        // module setting
        $this->call([
            ParishPatrimonySeeder::class
        ]);

        // module place
        $this->call([]);

        // module notification
        $this->call([]);
        

        Schema::enableForeignKeyConstraints();
        Model::reguard();
    }
}
