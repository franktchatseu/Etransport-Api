<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;


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

     // person
    $this->call([
      UserSeeder::class
      ]);

    // module1
    $this->call([
    ]);

    // module2
    $this->call([
    ]);

    Schema::enableForeignKeyConstraints();
    Model::reguard();
  }
}
