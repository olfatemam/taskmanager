<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name','reminder'
    ];
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
