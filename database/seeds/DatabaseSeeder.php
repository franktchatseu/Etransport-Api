<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use App\Models\Catechesis\Catechesis;

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

        // module extra
        // $this->call([
        //     _CebSeeder::class,
        //     _PostSeeder::class,
        //     _GroupSeeder::class,
        // ]);

        //$this->call(CityAndCountrySeeder::class);
        
        //module finance
        $this->call([
         NatureSeeder::class,
         InputSeeder::class
        ]); 

        // module setting
        $this->call([
             ParishSeeder::class,
            // ParishPatrimonySeeder::class,
            // MassSheduleSeeder::class
        ]);

       // $this->call(CityAndCountrySeeder::class);
        
        // module setting
        $this->call([
            // $this->call(SettingSeeder::class);
             // $this->call(LaratrustSeeder::class),
                ProfessionSeeder::class,
                UserSeeder::class,
                UtypeSeeder::class,
                UserUtypeSeeder::class,
                InputUUtypeSeeder::class,
            // ParishSeeder::class,
            //  PriestSeeder::class,
            //  AlbumSeeder::class,
            //  ParishionalSeeder::class,
            //  CathechumeneSeeder::class,
            //  ContactSeeder::class,
        ]);

        // module messagerie
        // $this->call([
        //     ChatGroupSeeder::class,
        //     ChatMemberGroupSeeder::class,
        //     ChatMessageGroupSeeder::class,
        //     ChatDiscussionSeeder::class,
        //     ChatMessageDuoSeeder::class
        // ]);

        // module actualité
        // $this->call([
        //     AttributeSeeder::class,
        //     ArticleSeeder::class,
        //     MenuSeeder::class,
        //     SubMenuSeeder::class,
        //     AttributMenuSeeder::class,
        //     ArticleAttributMenuSeeder::class
        // ]);

        // module sacrament
        $this->call([]);
        
        // module setting
        $this->call([
            //    ParishSeeder::class,
            //   AlbumSeeder::class,
            //   ContactSeeder::class,
            //   ParishPatrimonySeeder::class,
            //   MassSheduleSeeder::class,
            //   PhotoSeeder::class,
            //   UserParishSeeder::class,
            //   ParishAlbumSeeder::class 
        ]);

        // module catechesis
         $this->call([
            //MemberSeeder::class,
            // AnnualMemberSeeder::class,
             //TransfertSeeder::class,
             //AuthorizationSeeder::class,
            // MemberTransfertSeeder::class,
            // CatechesisSeeder::class,
            // ArchivingSeeder::class,
            
           //  AnnualMemberSeeder::class,
             //MemberSeeder::class,
             //ArchivingSeeder::class,
            // ProgrammeSeeder::class,
             //ProgrammeSeeder::class,
             //MemberSeeder::class,
             //ArchivingSeeder::class,
            //  ProgrammeSeeder::class,
              //TrimestreSeeder::class,
              //QuarterSeeder::class,
              //QuarterTrimestreSeeder::class,
              //AnnualMemberSeeder::class,
            // AnnualmemberAuthorizationSeeder::class, 
         ]);

        // module place
        $this->call([]);
        
        // module sanction
        $this->call([
            //  PunishmentTypeSeeder::class,
            //  SanctionSeeder::class,
            //  UserSanctionSeeder::class 
        ]);

          // module catechese
          $this->call([
               // QuarterSeeder::class,
               //EvaluationSeeder::class,
            //    TimeCardSeeder::class,
            //    PatternSeeder::class,
            //    PlugSeeder::class,
            //    CathedralPresenceSeeder::class,
            //    UserCatechesisSeeder::class,
            //    CatechesisPresenceSeeder::class 

            
          ]);

        // module planification
        $this->call([]);

        // module finance
        $this->call([
              /* RequestForMassSeeder::class,
              TarifSeeder::class, */
          //   ]);

          // module place
          //   $this->call([
          /*  PlaceTypeSeeder::class,
              PlaceSeeder::class,
             TypePosteSeeder::class,
              PosteSeeder::class, */
          //     ]);

          

          // module association
          // $this->call([
          //      TypeAssociationSeeder::class,
          //      AssociationSeeder::class,
          //      EvenementSeeder::class,
          //      StatutSeeder::class,
          //      MemberAssociationSeeder::class,
          //      EventPresenceMemberAssociationSeeder::class,
           ]);

          // module statistic
          $this->call([]);

          // module sacrament
          $this->call([
               //SacramentCategorySeeder::class,
               //SacramentSeeder::class,
               //UserSacramentSeeder::class,
          ]);

          //module Planification
          $this->call([
               /*    TypePlaningSeeder::class,
           PlaningSeeder::class,
           AssociationPlaningSeeder::class,
           UserPlaningSeeder::class */]);

           //module actuality
           $this->call([
                // AttributeSeeder::class,
                // MenuSeeder::class,
                //AttributeMenuSeeder::class,
                // SubMenuSeeder::class,
                // ArticleSeeder::class,
                // ArticleAttributeMenuSeeder::class,
           ]);

          Schema::enableForeignKeyConstraints();
          Model::reguard();
     }
}
