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

        //$this->call(CityAndCountrySeeder::class);
        
        // module person
        $this->call([
            // $this->call(SettingSeeder::class);
            // $this->call(LaratrustSeeder::class);
             UserSeeder::class,
            // ParishSeeder::class,
            // ProfessionSeeder::class,
            // PriestSeeder::class,
            // AlbumSeeder::class,
            // ParishionalSeeder::class,
            // CathechumeneSeeder::class,
            // ContactSeeder::class,
        ]);

        // module sacrament
        $this->call([]);
        
        // module setting
        $this->call([
            // ParishPatrimonySeeder::class,
            // MassSheduleSeeder::class
        ]);

        // module catechesis
         $this->call([
            // AnnualMemberSeeder::class,
            // MemberSeeder::class,
            // ArchivingSeeder::class
            ProgrammeSeeder::class
         ]);

        // module place
        $this->call([]);
        
        // module sanction
        $this->call([
            // PunishmentTypeSeeder::class,
            // SanctionSeeder::class,
            // UserSanctionSeeder::class
        ]);

          // module catechese
          $this->call([
            //   QuarterSeeder::class,
            //   EvaluationSeeder::class
          ]);

        // module planification
        $this->call([]);

        // module finance
        $this->call([
            // RequestForMassSeeder::class,
            // TarifSeeder::class,
        ]);
        
        // module place
        $this->call([
            //PlaceTypeSeeder::class,
            //PlaceSeeder::class,
           // TypePosteSeeder::class,
            //PosteSeeder::class,
        ]);

       // module finance
        $this->call([
            NatureSeeder::class
        ]);

        // module association
        $this->call([
            TypeAssociationSeeder::class,
            AssociationSeeder::class,
        ]);

        // module statistic
        $this->call([]);

        // module sacrament
        $this->call([
            SacramentCategorySeeder::class,
            SacramentSeeder::class,
            UserSacramentSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
        Model::reguard();

        
    }
}
