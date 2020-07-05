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
    
    public static function getNew()
    {
        $statuses = Status::where('name','New')->get();
        if(!$statuses->count())
        {
            return Status::create(['name'=>'New', 'reminder'=>true]);
        }
        return $statuses->first();
    }
}
