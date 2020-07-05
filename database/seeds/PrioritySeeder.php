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
        $seeds=[
            ['name'=>'High', 'number'=>10, 'background_color'=>'#b8daff', 'text_color'=>'#212529'], 
            ['name'=>'Normal', 'number'=>5, 'background_color'=>'#b8daff', 'text_color'=>'#212529'], 
            ['name'=>'Low', 'number'=>4, 'background_color'=>'#ffeeba', 'text_color'=>'#212529'], 
            ['name'=>'None', 'number'=>1, 'background_color'=>'#fdfdfe', 'text_color'=>'#212529'] 
            ];
        foreach($seeds as $seed)
        {
            \App\Priority::create($seed);
        }
    }
}
