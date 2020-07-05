<?php

namespace App;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Task extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    
    public function priority()
    {
        return $this->belongsTo('App\Priority');
    }
        //
    
    public function read_input($request)
    {
        $this->name         =   $request['name'];
        $this->user_id      =   Auth::user()->id;//$request['name'];
        $this->description  =   $request['description'];
        
        
        $date =  new \DateTime($request['due']); 
        Log::info("due:=". $request['due']);
        //Log::info("date:=", $date);
        $this->due          =   $date->format('Y-m-d H:i:s');
        
        $this->priority_id  =   $request['priority_id'];
        $this->status_id    =   $request['status_id'];
        $this->reminder     =   ($request['reminder']==null)?false:$request['reminder'];
        $this->timezone     =   $request['tzone'];
    }
          
    public function send_reminder_email()
    {
        Mail::to($this->user)->cc('olfat.emam@gmail.com')->send(new \App\Mail\TaskReminder($this));
    }
}
