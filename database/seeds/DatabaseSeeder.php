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
            $this->call([
                StatusSeeder::class,
                PrioritySeeder::class,
        
    ]);
        // $this->call(UserSeeder::class);
    }
}
