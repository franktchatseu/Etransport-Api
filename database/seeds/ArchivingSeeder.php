<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\Archiving;

class ArchivingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Archiving::class, 100)->make()->each(function ($archiv) use ($faker) {
            $archiv->save();
        });

    }
}
