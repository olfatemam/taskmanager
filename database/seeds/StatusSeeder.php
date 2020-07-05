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
            ['name'=>'Paused'], 
            ['name'=>'Delayed'],
            ['name'=>'Finished', 'remind'=>false], 
            ['name'=>'Canceled',  'remind'=>false]];
        foreach($seeds as $seed)
        {
            \App\Status::create($seed);
        }
    }
}
