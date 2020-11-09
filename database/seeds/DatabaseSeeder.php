<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(InsertSeeder::class);
         $this->call(UpdateSeeder::class);
         $this->call(DeleteSeeder::class);

    }
    
  
}
