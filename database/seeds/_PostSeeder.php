<?php

use Illuminate\Database\Seeder;

class _PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'Banki',
            'Mvoh',
            'Maka',
            'Nzindeng'
        ];

        DB::table('_postes')->delete();
        foreach ($list as $key => $value) {
            DB::table('_postes')->insert([
                'name' => $value,
            ]);
        }
    }
}
