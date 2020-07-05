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
        $seeds=[
            ['name'=>'New'], 
            ['name'=>'Finished', 'reminder'=>false], 
            ['name'=>'Canceled',  'reminder'=>false]];
        foreach($seeds as $seed)
        {
            \App\Status::create($seed);
        }
    }
}
