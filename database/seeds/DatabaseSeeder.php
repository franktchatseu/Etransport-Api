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
        
        // module person
        $this->call([
            // $this->call(SettingSeeder::class);
            // $this->call(LaratrustSeeder::class);
            UserSeeder::class,
            ProfessionsSeeder::class,
            PriestSeeder::class,
            AlbumSeeder::class,
            ParishionalSeeder::class,
            ParishSeeder::class,
        ]);
        
        // module setting
        $this->call([
            ParishPatrimonySeeder::class,
            MassSheduleSeeder::class
        ]);

        // module place
        $this->call([]);
        
        // module sanction
        $this->call([
            PunishmentTypeSeeder::class,
            SanctionSeeder::class,
            UserSanctionSeeder::class
        ]);

        // module planification
        $this->call([]);

        
        // module place
        $this->call([
            PlaceTypeSeeder::class,
            PlaceSeeder::class
        ]);

       // module finance
        $this->call([]);

        // module association
        $this->call([]);

        // module statistic
        $this->call([]);

        Schema::enableForeignKeyConstraints();
        Model::reguard();
    }
}
