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
    
    public function tags() 
    {
        return view('tasks.tags');
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
        if(Auth::user()->is_admin())
        {
            $users= User::pluck('name', 'id');//->where('role', 'User');
        }
        else
        {
            $users= collect([Auth::user()]);
            $users=$users->pluck('name', 'id');
        }
        $query = Task::select("*");

        if(Auth::user()->is_admin()==false)
        {
            $tasks = $query->where('user_id',Auth::user()->id);
        }
        elseif($request['user_id'])
        {
            $tasks = $query->where('user_id',$request['user_id']);
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
        $request->flash();
        
        return view('tasks.list_filtered', compact('tasks', 'users', 'filter'));
    }
    
    public function search(Request $request)
    {
        return $this->search_generic($request, 'tasks.search', 'tasks.search', false);
    }
    
    public function search_generic(Request $request, $view, $route, $ignore_completed)
    {
        $tasks = Task::orderby('due', 'asc');
        
        if(Auth::user()->is_admin()==false)
        {
            $tasks=$tasks->where('user_id',Auth::user()->id);
        }
        elseif($request['user_id'])
        {
            $tasks=$tasks->where('user_id',$request['user_id']);
        }
            
        if($ignore_completed==true)
        {
            $tasks=$tasks->where('completed',false);
        }
        if($request['priority_id'])
        {
            $tasks=$tasks->where('priority_id',$request['priority_id']);
        }
        $tasks=$tasks->paginate(10); //show only 5 items at a time in descending order
        $priorities= Priority::pluck('name', 'id');
        if(Auth::user()->is_admin())
        {
            $users= User::pluck('name', 'id');//->where('role', 'User');
        }
        else
        {
            $users= collect([Auth::user()]);
            $users=$users->pluck('name', 'id');
        }
        $request->flash();
        return view($view, compact('route', 'tasks', 'users','priorities'));
    }

    public function create()
    {
        
        //$statuses=Status::pluck('name', 'id');
        $priorities= Priority::pluck('name', 'id');
        
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
        $statuses=Status::pluck('name', 'id');
        $priorities= Priority::pluck('name', 'id');
        return view('tasks.edit', compact('task', 'statuses', 'priorities'));
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
    
}
