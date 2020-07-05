<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $fillable = [
        'name', 'background_color', 'text_color'
    ];
    
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
    
}
