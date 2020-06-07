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
        
        // module setting
        $this->call([
            ParishSeeder::class,
            // ParishPatrimonySeeder::class,
            // MassSheduleSeeder::class
        ]);

        // module person
        $this->call([
            // $this->call(SettingSeeder::class);
            // $this->call(LaratrustSeeder::class);
             UserSeeder::class,
             UtypeSeeder::class,
             UserUtypeSeeder::class,
             ParishSeeder::class,
             ProfessionSeeder::class,
             PriestSeeder::class,
            // AlbumSeeder::class,
             ParishionalSeeder::class,
             CathechumeneSeeder::class,
            // ContactSeeder::class,
        ]);

        // module sacrament
        $this->call([]);
        
        // module catechesis
         $this->call([
            // AnnualMemberSeeder::class,
             MemberSeeder::class,
             TransfertSeeder::class,
             MemberTransfertSeeder::class,
            // ArchivingSeeder::class
            // ProgrammeSeeder::class
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
            // EvaluationSeeder::class,
            // CatechesisSeeder::class,
            // TimeCardSeeder::class,
            // PatternSeeder::class,
            // PlugSeeder::class
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
            // PlaceTypeSeeder::class,
            // PlaceSeeder::class,
           // TypePosteSeeder::class,
            // PosteSeeder::class,
        ]);

       // module finance
        $this->call([
            // NatureSeeder::class
        ]);

        // module association
        $this->call([
            // TypeAssociationSeeder::class,
            // AssociationSeeder::class,
        ]);

        // module statistic
        $this->call([]);

        // module sacrament
        $this->call([
            // SacramentCategorySeeder::class,
            // SacramentSeeder::class,
            // UserSacramentSeeder::class,
        ]);

         // module Planification
         $this->call([
        //   TypePlaningSeeder::class,
        //   PlaningSeeder::class,
        //   AssociationPlaningSeeder::class,
        //   UserPlaningSeeder::class
        ]);

        Schema::enableForeignKeyConstraints();
        Model::reguard();

        
    }
}
