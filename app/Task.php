<?php

namespace App;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    const Active='Active';
    const Today='Today';
    const Coming='Coming';
    const Overdue='Overdue';
    const Finished='Finished';

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
        $query = 'select '
                . ' tasks.id as task_id, '
                . ' tasks.name as title, '
                . ' tasks.id as id, '
                . ' tasks.due as start, '
                . ' tasks.completed as completed, '
                . ' tasks.description as description, '
                . ' tasks.timezone as timezone, '
                . ' priorities.name as priority, '
                . ' priorities.background_color as color, '
                . ' priorities.name as priority, '
                . ' users.name as user_name, '
                . ' users.id as user_id '
                . ' from tasks '
                . ' inner join statuses on tasks.status_id=statuses.id '
                . ' inner join priorities on tasks.priority_id=priorities.id '
                . ' inner join users on tasks.user_id=users.id ';
                
        if(Auth::user()->is_admin()==false)
        {
            $query = $query. ' where tasks.user_id = '. Auth::user()->id .' ';
        }
        $tasks=DB::select($query);
        
        return $tasks; 
    }
    public function overdue()
    {
        if($this->completed==true)return false;
        
        $tzone  = new \DateTimeZone($this->timezone);
        $now = new \DateTime("now", $tzone);
        $due = new \DateTime($this->due, $tzone);
        
        return ($due<$now);
    }
    
    public function tags()
    {
        $tags_html="";
        $tags_arr = explode(" ", $this->description);
        foreach($tags_arr as $tag)
        { 
            $tags_html .='<span class="w3-border w3-round" style="margin-left:5px">' .$tag . '</span>&nbsp;';
        }
        return $tags_html;
    }
    public function state()
    {
        $state_html="";

        if($this->overdue()==true)
            $state_html.= '<span class="btn-warning rounded float-right" style="margin-left:5px">overdue</span>&nbsp;';

        if($this->completed)
            $state_html.= '<span class="btn-success rounded float-right" style="margin-left:5px">completed</span>&nbsp;';
        
        else if($this->reminder)//change to the time of the reminder based on the task attr : reminde_before
            $state_html.= '<span class="btn-info rounded float-right" style="margin-left:5px">reminder</span>&nbsp;';
        

        return $state_html;
    }

    public function hagar_due()
    {
        $date = new \DateTime($this->due);
        return $date->format("D j, M y   h:i A");
    }
    
    public static function get_tags_and_frequencies($user_id)
    {
        $descriptions = Task::select('description');
        
        if($user_id!=null && $user_id>0)
            $descriptions = $descriptions->where('user_id', $user_id);
        
        $descriptions = $descriptions->get();
        
        
        $tags = $descriptions->implode(' ');
        $tags_array = explode(" ",$tags);
        
        //Array fr will store frequencies of element  
        $fr = array_fill(0, count($tags_array), 0);  
        $visited = -1;  
   
        for($i = 0; $i < count($tags_array); $i++)
        {  
            $count = 1;  
            for($j = $i+1; $j < count($tags_array); $j++){  
            if(strcmp($tags_array[$i], $tags_array[$j])==0)
            {  
                $count++;  
                //To avoid counting same element again  
                $fr[$j] = $visited;  
            }  
        }  
        if($fr[$i] != $visited)  
            $fr[$i] = $count;  
        }  
      
        //Displays the frequency of each element present in array  
        Log::info("-------------------------<br>");  
        Log::info(" Element | Frequency<br>");  
        Log::info("-------------------------<br>");  
        
        $result=[];
        
        for($i = 0; $i < count($fr); $i++)
        {  
            if($fr[$i] != $visited)
            {  
                $result[]=[$tags_array[$i], $fr[$i]];
                Log::info(str_repeat(' ', 6) . $tags_array[$i] );  
                Log::info(str_repeat(' ', 7) . "|" . str_repeat(' ', 7) . $fr[$i]);  
            }  
        }
        return $result;
    }  
}
