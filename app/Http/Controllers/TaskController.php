<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Auth;
use App\Task;
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
    
    public function tags(Request $request) 
    {
        $users= $this->get_users_for_select();
        
        $tags = Task::get_tags_and_frequencies($request['user_id']);
        
        $tasks=Task::select("*");
        
        if($request['user_id']>0)$tasks = $tasks->where('user_id',$user_id);
        
        if($request['priority_id'])
        {
            Log::info("priority_id",$request['priority_id']);
            $tasks=$tasks->whereIn('priority_id', $request['priority_id']);
        }
        $tag_search = $request['tag_search'];
        
        if($tag_search)
        {
            $keywords = explode(" ", $tag_search);
            Log::info('$keywords', $keywords);
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
        $tasks=$tasks->paginate(10);
        $priorities= Priority::get();//pluck('name', 'id');
        $request->flash();
        return view('tasks.tags', compact('priorities', 'users', 'tags', 'tasks'));
    }
    
    public function index() 
    {
    }

    public function list(Request $request)
    {
        return $this->search_generic($request, 'tasks.list', 'tasks.list', true);
    }
    
    public function list_filtered(Request $request, $filter)
    {
        $users= $this->get_users_for_select();

        $query = Task::select("*");

        if($request['user_id'])
        {
            $tasks = $query->where('user_id',$request['user_id']);
        }
        

        if($request['priority_id'])
        {
            Log::info("priority_id",$request['priority_id']);
            $tasks=$tasks->whereIn('priority_id', $request['priority_id']);
        }
        
        switch($filter)
        {
            case Task::Today:
                $query = $query->whereDate('due', '=',Carbon::today()->toDateString());
            break;
            case Task::Active:
                $query = $query->where('completed', false);
            break;
        
            case Task::Coming:
                $query = $query->where('due', '>=',Carbon::now()->toDateTimeString());
                
            break;
        
            case Task::Overdue:
                $query = $query->where('due', '<', Carbon::now()->toDateTimeString());
                $query = $query->where('completed', false);
                
            break;
        
            case Task::Finished:
                $query = $query->where('completed',true);
            break;
        }
        $tasks=$query->paginate(10);
        $priorities= Priority::get();//pluck('name', 'id');
        $request->flash();
        
        return view('tasks.list_filtered', compact('tasks', 'users', 'priorities','filter'));
    }
    
    public function search(Request $request)
    {
        return $this->search_generic($request, 'tasks.search', 'tasks.search', false);
    }
    
    public function search_generic(Request $request, $view, $route, $ignore_completed)
    {
        $tasks = Task::orderby('due', 'asc');
        
        if($request['user_id'])
        {
            $tasks=$tasks->where('user_id',$request['user_id']);
        }
            
        if($ignore_completed==true)
        {
            $tasks=$tasks->where('completed',false);
        }
                
        if($request['priority_id'])
        {
            Log::info("priority_id",$request['priority_id']);
            $tasks=$tasks->whereIn('priority_id', $request['priority_id']);
        }
        $tasks=$tasks->paginate(10); //show only 5 items at a time in descending order
        
        $users= $this->get_users_for_select();

        $request->flash();

        $priorities= Priority::get();//pluck('name', 'id');
        
        return view($view, compact('route', 'tasks', 'users','priorities'));
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
                    //'description'=>'required|max:100',
                    'priority_id'=>'required',
                    'due'=>'required',
        ]);
        try
        {
            $task = new \App\Task();
            
            
            $task->read_input($request);
            
            $task->save();
            
            return redirect()->route('tasks.search');//->with('flash_message', 'Task '. $task->name.' created');
        }
        catch (\PDOException $e)
        {
            //Log::info('exception: ', print_r($e, false));
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
        
        return redirect()->route('tasks.list', $task->id)->with('flash_message', 'Task, '. $task->name.' completed.');
        
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

            return redirect()->route('tasks.search', 
                $task->id)->with('flash_message', 'Task, '. $task->name.' updated');
        }
        
        catch (\PDOException $e)
        {
            return \App\Helpers\DBError::report($e);
        }
    }

    
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.search')
            ->with('flash_message', 'Task deleted!');
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
        
}
