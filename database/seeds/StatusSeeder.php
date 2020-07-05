<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds=[['name'=>'New'], ['name'=>'Finished'], ['name'=>'Canceled'], ['name'=>'Paused'], ['name'=>'Delayed']];
        DB::table('statuses')->insert($seeds);
    }
}
