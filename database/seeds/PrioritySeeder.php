<?php

use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds=[['name'=>'High'], ['name'=>'Low'], ['name'=>'Normal'], ['name'=>'None']];
        foreach($seeds as $seed)
        {
            \App\Priority::create($seed);
        }
    }
}
