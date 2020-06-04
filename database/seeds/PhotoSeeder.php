<?php

use App\Models\Setting\Photo;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator$faker)
    {
        factory(Photo::class, 10)->make()->each(function($photo) use ($faker){
            $album = App\Models\Setting\Album::all();
            $photo->album_id = $faker->randomElement($album)->id;
            $photo->save();
        });
    }
}
