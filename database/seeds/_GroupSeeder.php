<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class _GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'Lecteurs',
            'Enfant de cœur',
            'Réseaux',
            'ACE COP Monde',
            'JEC',
            'Chorale des Saints Anges',
            'Chorale Saint Dominique Savio',
            'Chorale Chœur Angélique',
            'Chorale Sainte Thérèse',
            'Miséricorde divine',
            'Légion de Marie',
            'Parole de Dieu',
            'AIC St Vincent',
            'Femmes catholiques',
            'Renouveau charismatique',
            'SCOUT',
            'Mont Ligeon',
            'Association des Hommes catholiques'
        ];
        DB::table('_groupes')->delete();
        foreach ($list as $key => $value) {
            DB::table('_groupes')->insert([
                'name' => $value,
            ]);
        }
    }
}
