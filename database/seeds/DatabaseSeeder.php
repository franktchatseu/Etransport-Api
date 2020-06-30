<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use App\Models\Catechesis\Catechesis;
// use App\Models\Request\ObjectMakingAppointment;
// use App\Models\Request\ObjectRequestMass;
// use App\Models\Request\MakingAppointment;
// use App\Models\Request\AnointingSick;
// use App\Models\Request\IntentionMass;
// use App\Models\Request\RequestMass;
// use App\Models\Request\ReportProblem;


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
    $this->call([
      // _CebSeeder::class,
      // _PostSeeder::class,
      // _GroupSeeder::class,
    ]);

    // $this->call(CityAndCountrySeeder::class);
    $this->call(SettingSeeder::class);
    // $this->call(LaratrustSeeder::class);

    // module setting
    $this->call([
      ParishSeeder::class,
      ParishPatrimonySeeder::class,
      MassSheduleSeeder::class,
      AlbumSeeder::class,
      ProfessionSeeder::class,
      MassSheduleSeeder::class,
    ]);

    // module finance
    $this->call([
      NatureSeeder::class
    ]);

    // module person
    $this->call([
      UserSeeder::class,
      UtypeSeeder::class,
      UserUtypeSeeder::class,
      ContactSeeder::class,
      PriestSeeder::class,
      ParishionalSeeder::class,
      TypeAssociationSeeder::class,
      AssociationSeeder::class,
      MemberAssociationSeeder::class,
      AlbumSeeder::class,
      InputUUtypeSeeder::class,
      // CatechistSeeder::class,
      InputSeeder::class,
      
      CathechumeneSeeder::class,
      ContactSeeder::class,
      AgendaSeeder::class, /*  */
      ParishAlbumSeeder::class,
      PhotoSeeder::class,
      UserParishSeeder::class,
    ]);
    

    // module messagerie
    $this->call([
      // ChatGroupSeeder::class,
      // ChatMemberGroupSeeder::class,
      // ChatMessageGroupSeeder::class,
      // ChatDiscussionSeeder::class,
      // ChatMessageDuoSeeder::class
    ]);

    // module publicité
    $this->call([
       PublicitySeeder::class,
    ]);

    // module catechesis
    // $this->call([
    //   MemberSeeder::class,
    //   AnnualMemberSeeder::class,
    //   TransfertSeeder::class,
    //   AuthorizationSeeder::class,
    //   MemberTransfertSeeder::class,
    //   CatechesisSeeder::class,
    //   ArchivingSeeder::class,
    //   AnnualMemberSeeder::class,
    //   MemberSeeder::class,
    //   ArchivingSeeder::class,
    //   ProgrammeSeeder::class,
    //   ProgrammeSeeder::class,
    //   MemberSeeder::class,
    //   ArchivingSeeder::class,
    //   ProgrammeSeeder::class,
    //   TrimestreSeeder::class,
    //   QuarterSeeder::class,
    //   QuarterTrimestreSeeder::class,
    //   AnnualMemberSeeder::class,
    //   AnnualmemberAuthorizationSeeder::class,
    // ]);

    // module place
    $this->call([]);

    // module sanction
    // $this->call([
    //   PunishmentTypeSeeder::class,
    //   SanctionSeeder::class,
    //   UserSanctionSeeder::class
    // ]);

    // module catechese
    $this->call([
      // QuarterSeeder::class,
      // EvaluationSeeder::class,
      // TimeCardSeeder::class,
      // PatternSeeder::class,
      // PlugSeeder::class,
      // CathedralPresenceSeeder::class,
      // UserCatechesisSeeder::class,
      // CatechesisPresenceSeeder::class
    ]);

    // module planification
    $this->call([]);

    // module finance
    $this->call([]);

    // module place
    // $this->call([
    //   PlaceTypeSeeder::class,
    //   PlaceSeeder::class,
    //   TypePosteSeeder::class,
    //   PosteSeeder::class,
    // ]);

    // module association
    $this->call([
      
    //   EvenementSeeder::class,
    //   StatutSeeder::class,
       
    //   EventPresenceMemberAssociationSeeder::class,
    ]);

    // module statistic
    /* $this->call([]); */

    // module sacrament
    // $this->call([
    //   SacramentCategorySeeder::class,
    //   SacramentSeeder::class,
    //   UserSacramentSeeder::class,
    // ]);

    //module Planification
    $this->call([
      ObjectMakingAppointmentSeeder::class,
      MakeAppointmentSeeder::class,
      AnointingSickSeeder::class,
      ObjectRequestMassSeeder::class,
      IntentionMassSeeder::class,
      RequestMassSeeder::class,
      ReportProblemSeeder::class,
      TypePlaningSeeder::class,
      PlaningSeeder::class,
      AssociationPlaningSeeder::class,
      UserPlaningSeeder::class
    ]);

    //module actuality
    $this->call([
      AttributeSeeder::class,
      MenuSeeder::class,
      AttributeMenuSeeder::class,
      SubMenuSeeder::class,
      ArticleSeeder::class,
      ArticleAttributeMenuSeeder::class,
    ]);

    //module liturgical
    $this->call([
      LiturgicalTypeSeeder::class,
      EntryTypeSeeder::class,
      LiturgicalTypeEntryTypeSeeder::class,
      LiturgicalTextSeeder::class,
    ]);

    Schema::enableForeignKeyConstraints();
    Model::reguard();
  }
}
