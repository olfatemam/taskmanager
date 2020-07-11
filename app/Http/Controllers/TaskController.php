<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Auth;
use App\Task;
use App\Enum\TaskFilter;
use Carbon\Carbon;
use App\User;
use App\Status;
use App\Priority;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
    }
    public function tags(Request $request, $tag)
    {
        $request['tag_search']=$tag;
        //log::info("$request[tag_search]=" . $request['tag_search']);
        return $this->search($request, TaskFilter::Tags);
    }
    
    public function search(Request $request, $filter)
    {
        $rows_style=($filter==TaskFilter::Search)?'table':'ul';
        
        $user_id = self::get_user_id($request['user_id']);
        
        $tasks = Task::Search($request, $user_id, $filter);
        
        $tasks=$tasks->paginate(10);
        
        /////////////////////////////////////////////////
        
        $users= $this->get_users_for_select();
        $priorities= Priority::get();
        
        $request->flash();
        return view('tasks.search', compact('priorities', 'users', 'tasks', 'filter', 'rows_style'));
    }
    
    

    public function create()
    {
        
        $priorities= Priority::get();//pluck('name', 'id');
        
        return view('tasks.create', compact('priorities'));
    }

    public function store(Request $request)
    {
        $request->validate([
                    'name'=>'required|max:100',
                    'timezone'=>'required|max:100',
                    //'description'=>'required|max:100',
                    'priority_id'=>'required',
                    'due'=>'required',
        ]);
        try
        {
            $task = new \App\Task();
            
            
            $task->read_input($request);
            
            $task->save();
            
            return redirect()->route('tasks.search', TaskFilter::Search);//->with('flash_message', 'Task '. $task->name.' created');
        }
        catch (\PDOException $e)
        {
            ////log::info('exception: ', print_r($e, false));
            return \App\Helpers\DBError::report($e);
        }
        
    }


    public function show(Task $task)
    {
        return view ('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        
        $priorities= Priority::get();
        return view('tasks.edit', compact('task', 'priorities'));
    }

    public function complete($id)
    {
        $task = Task::findOrFail($id);
        $task->completed = true;
        //$task->completion_time=now();//olfat: add completion time
        $task->save(); 
        
        return redirect()->route('tasks.search',TaskFilter::Search)->with('flash_message', 'Task, '. $task->name.' completed.');
        
    }

    
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'name'=>'required|max:200',
            'priority_id'=>'required',
            //'status_id'=>'required',
            'due'=>'required',
        ]);

        try
        {
            $task->read_input($request);
            
            $task->save();

            return redirect()->route('tasks.search',TaskFilter::Search)->with('flash_message', 'Task, '. $task->name.' updated');
        }
        
        catch (\PDOException $e)
        {
            return \App\Helpers\DBError::report($e);
        }
    }

    
    public function destroy(Task $task)
    {
        try
        {
            Log::info('hello');
            $task->delete();
            return redirect()->route('tasks.search', TaskFilter::Search)
                ->with('flash_message', 'Task deleted!');
        }
        catch (\PDOException $e)
        {
            return \App\Helpers\DBError::report($e);
        }
    }
    
    public function calendar()
    {
        $tasks= \App\Task::get_calendar_user_tasks();
        return view('tasks.calendar', compact('tasks'));
    }
    private function get_users_for_select()
    {
        if(Auth::user()->is_admin())
        {
            $users= User::pluck('name', 'id');//->where('role', 'User');
        }
        else
        {
            $users= collect([Auth::user()]);
            $users=$users->pluck('name', 'id');
        }        
        return $users;
    }
    private static function get_user_id($user_id)
    {
        if(!Auth::user()->is_admin()==true) 
        {
            return Auth::user()->id;
        }
        else
        {
            return $user_id;
        }
    }    
    
    public function store_from_calendar(Request $request)
    {
        try
        {
            $isnew=false;
            $data = $request->all();
            if($data['task_id']>0)
            {
                $task = Task::findOrFail($data['task_id']);
            }
            else
            {
                $task = new Task();
                $isnew=true;
            }
            if(!isset($data['completed']))$data['completed']=false;
            if(!isset($data['reminder']))$data['reminder']=false;
            
            Log::info('data=',$data);
            
            $task->read_input($data);
            
            if($isnew==true)//olfat:TBD: admin currently can edit all events this need to change
                $task->user_id=Auth::user()->id;
            
            $task->save();
            
            $task->task_id=$task->id;
            $task->is_new=$isnew;
            
            $task->color=$task->priority->background_color;
            $task->priority_name=$task->priority->name;
            $task->status_name=$task->status->name;
            $task->title=$task->name;
            $task->user_name=$task->user->name;
            
            return response()->json(['success'=>$task]);
        }
        catch(\PDOException $e)
        {
            return response()->json(['error'=> \App\Helpers\DBError::get_readable_sql_error($e)]);;
        }
    }    
}
