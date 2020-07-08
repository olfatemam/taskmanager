<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $fillable = [
        'name', 'background_color', 'text_color'
    ];

    public static function getNormalId()
    {
        $normal = ['name'=>'Normal', 'number'=>5, 'background_color'=>'#b8daff', 'text_color'=>'#212529']; 
        $normal_obj = Priority::where('name', 'Normal')->first();
        if(!$normal_obj)
        {
            $normal_obj = \App\Priority::create($normal);
        }
        return $normal_obj->id;
    }
    
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
    
}
