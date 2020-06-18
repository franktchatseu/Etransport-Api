<?php

use App\Models\Setting\ParishAlbum;
use Illuminate\Database\Seeder;

class ParishAlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(ParishAlbum::class, 100)->make()->each(function ($albumparish) use ($faker) {
            $album = App\Models\Setting\Album::all();
            $parish = App\Models\Setting\Parish::all();
            $albumparish->album_id = $faker->randomElement($album)->id;
            $albumparish->parish_id = $faker->randomElement($parish)->id;
            $albumparish->save();
        });
    }
}
