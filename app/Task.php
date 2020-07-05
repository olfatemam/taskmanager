<?php

namespace App;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

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
        $this->name             =   $request['name'];
        $this->completed        =   $request['completed'];
        
        $this->user_id      =   Auth::user()->id;//$request['name'];
        $this->description  =   $request['description'];
        
        
        $date =  new \DateTime($request['due']); 
        $this->due          =   $date->format('Y-m-d H:i:s');
        
        $this->priority_id  =   $request['priority_id'];
        //$this->status_id    =   $request['status_id'];
        $this->reminder     =   ($request['reminder']==null)?false:$request['reminder'];
        $this->completed     =   ($request['completed']==null)?false:$request['completed'];
        $this->timezone     =   $request['timezone'];
        
        
        if(!$this->status_id)
        {
            $status=Status::getNew();
            $this->status_id=$status->id;
        }
        if($this->completed==true)
            $this->reminder=false;
        
    }
          
    public function send_reminder_email()
    {
        Mail::to($this->user)->cc('olfat.emam@gmail.com')->send(new \App\Mail\TaskReminder($this));
    }
    
    public function get_task_class()
    {
        return ($this->status->remind)?"table-primary": "table-dark";
    }
    public function get_task_style()
    {
        return ($this->status->remind)?"": "text-decoration: line-through;";
    }
    
    public static function get_calendar_user_tasks()
    {
        $query = 'select tasks.id as id, tasks.name as title, '
                . ' tasks.due as start, tasks.timezone as timezone, '
                . ' statuses.name as status, '
                . ' priorities.name as priority from tasks '
                . ' inner join statuses on tasks.status_id=statuses.id '
                . ' inner join priorities on tasks.priority_id=priorities.id ';
                
        if(Auth::user()->is_admin()==false)
        {
            $query = $query. ' where tasks.user_id = '. Auth::user()->id .' ';
        }
        $tasks=DB::select($query);
        
        return $tasks; 
    }
    public function overdue()
    {
        
        $tzone  = new \DateTimeZone($this->timezone);
        $now = new \DateTime("now", $tzone);
        $due = new \DateTime($this->due, $tzone);
        
        return ($due<$now);
    }

    public function hagar_due()
    {
        $date = new \DateTime($this->due);
        return $date->format("D j, M y   h:i A");
    }
    
    
}
