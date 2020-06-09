<?php

use Illuminate\Database\Seeder;
use App\Models\Setting\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *@autor Sikounmo  françois xavier
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Contact::class,21)->make()->each(function ($contact) use ($faker){
            $parishs = App\Models\Setting\Parish::all();
            $contact->parish_id = $faker->randomElement($parishs)->id;
            $contact->save();

        });
    }
}
