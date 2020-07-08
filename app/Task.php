<?php

namespace App;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Enum\TaskFilter;
use Carbon\Carbon;

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
        
//store in utc
        
        $tzone =  new \DateTimeZone($request['timezone']); 
        $utczone =  new \DateTimeZone("UTC"); 
        $date =  new \DateTime($request['due'], $tzone); 
        $date->setTimezone($utczone);
        
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
          

    public function hagar_due()
    {
        $utczone =  new \DateTimeZone("UTC"); 
        $tzone =  new \DateTimeZone($this->timezone); 
        $date =  new \DateTime($this->due, $utczone); 
        $date->setTimezone($tzone);
        
        return $date->format("D j, M   h:i A");
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
                . ' tasks.due as due, '
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

    public static function get_tags_and_frequencies()
    {
        $descriptions = Task::select('description');
        if(Auth::user()->is_admin()==false)
            $descriptions = $descriptions->where('user_id', Auth::user()->id);
            
        $descriptions = $descriptions->get();
        
        
        $tags = $descriptions->implode('description', ' ');
        //log::info('all tags='.$tags);
        
        $tags_array = explode(' ',$tags);
        //log::info('tags aray=', $tags_array);
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
        //log::info("-------------------------<br>");  
        //log::info(" Element | Frequency<br>");  
        
        $result=[];
        
        for($i = 0; $i < count($fr); $i++)
        {  
            if($fr[$i] != $visited)
            {  
                $result[]=[$tags_array[$i], $fr[$i]];
            }  
        }
        //log::info("-------------------------<br>");  
        return $result;
    }  

    public static function Search($request, $user_id, $filter)
    {
        $tasks = Task::orderby('due', 'desc');

        if($user_id>0)
        {
            $task=$tasks->where('user_id',$user_id);
        }
        if($request['priority_id'])
        {
            $tasks=$tasks->whereIn('priority_id', $request['priority_id']);
        }
        $tag_search = $request['tag_search'];
        if($tag_search)
        {
            $keywords = explode(" ", $tag_search);
            //log::info('$keywords', $keywords);
            if(count($keywords)>0)
            {
                $result = $tasks->where(function($query) use($keywords)
                {
                        foreach($keywords as $keyword)
                        {
                            $query->orWhere('description', 'LIKE', "%$keyword%");
                        }
                });
            }
        }
        
        return self::add_filter($tasks, $filter);
        
    }
    
    public static function add_filter($query, $filter)
    {
        switch($filter)
        {
            case TaskFilter::Today:
                $query = $query->whereDate('due', '=',Carbon::today()->toDateString());
            break;
            case TaskFilter::Active:
                $query = $query->where('completed', false);
            break;
        
            case TaskFilter::Coming:
                $query = $query->where('due', '>=',Carbon::now()->toDateTimeString());
                
            break;
        
            case TaskFilter::Overdue:
                $query = $query->where('due', '<', Carbon::now()->toDateTimeString());
                $query = $query->where('completed', false);
                
            break;
        
            case TaskFilter::Finished:
                $query = $query->where('completed', true);
            break;
        }
        return $query;
    }

}
