<?php

use Illuminate\Database\Seeder; 
use App\Models\Person\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    
        public function run(\Faker\Generator $faker)
    {
        $list = [
            'Banki',
            'Mvoh',
            'Maka',
            'Nzindeng'
        ];

        DB::table('professions')->delete();
        foreach ($list as $key => $value) {
            DB::table('professions')->insert([
                'name' => $value,
            ]);
        }

        // factory(Profession::class, 21)->make()->each(function ($professions) use ($faker) {
        //     $professions->save();
        // });
    }
    
}
