<?php

namespace App\Http\Controllers;

use App\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    public function search()
    {
        $priorities = Priority::get();
        return view('priorities.search', compact('priorities'));
    }
    public function index()
    {
        return $this->search();
    }


    public function create()
    {
        return view('priorities.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
                    'name'=>'required|max:100',
        ]);
        try
        {
            $priority = Priority::create(['name'=>$request['name']]);
            return redirect()->route('priorities.search');//->with('flash_message', 'Task '. $priority->name.' created');
        }
        catch (\PDOException $e)
        {
            return \App\Helpers\DBError::report($e);
        }
    }

    public function show(Priority $priority)
    {
        return view ('priorities.show', compact('priority'));

    }


    public function edit(Priority $priority)
    {
        return view('priorities.edit', compact('task'));
    }


    public function update(Request $request, Priority $priority)
    {
        $this->validate($request, [
            'name'=>'required|max:200',
        ]);

        try
        {
            $priority->name=$request['name'];
            
            $priority->save();

            return redirect()->route('priorities.search', $priority->id)->with('flash_message', 'Priority, '. $priority->name.' updated');
        }
        
        catch (\PDOException $e)
        {
            return \App\Helpers\DBError::report($e);
        }
    }


    public function destroy(Priority $priority)
    {
        $priority->delete();
        return redirect()->route('priorities.search')->with('flash_message', 'Priority deleted!');
    }
}
