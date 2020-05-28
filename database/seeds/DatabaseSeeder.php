<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use App\Models\Finance\RequestForMass;

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

        // module planification
        $this->call([]);

        // module finance
        $this->call([
            RequestForMassSeeder::class
        ]);

        // module association
        $this->call([]);

        // module statistic
        $this->call([]);

        Schema::enableForeignKeyConstraints();
        Model::reguard();
    }
}
