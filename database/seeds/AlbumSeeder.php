<?php

use App\Models\Setting\Album;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Album::class, 100)->make()->each(function ($album) use ($faker) {
            $album->save();
        });
    }
}
