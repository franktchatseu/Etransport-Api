<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class _CebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'Ste Félicité',
            'St Grégoire',
            'St Jacob',
            'Notre Dame de l\'espérance',
            'St Richard',
            'St Joseph', 
            'St Aloys',
            'St Constat',
            'St Pierre',
            'St Benoît',
            'Ste Marie Mère de Dieu',
            'St Michel Archange',
            'St Roger',
            'St Bernard',
            'St Etienne',
        ];

        DB::table('_cebs')->delete();
        foreach ($list as $key => $value) {
            DB::table('_cebs')->insert([
                'name' => $value,
            ]);
        }
    }
}
