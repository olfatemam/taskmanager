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
            'number'=>'required|max:10',
            'background_color'=>'required',
            'text_color'=>'required',        
       ]);
        try
        {
            $priority = Priority::create(
                    [
                        'name'=>$request['name'],
                        'number'=>$request['number'],
                        'background_color'=>$request['background_color'],
                        'text_color'=>$request['text_color']
                    
                    ]);
            return redirect()->route('priorities.search')->with('flash_message', 'Priority '. $priority->name.' created');
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
        return view('priorities.edit', compact('priority'));
    }


    public function update(Request $request, Priority $priority)
    {
        $this->validate($request, [
            'name'=>'required|max:100',
            'number'=>'required|max:10',
            'background_color'=>'required',
            'text_color'=>'required',
        ]);

        try
        {
            $priority->name=$request['name'];
            $priority->number=$request['number'];
            $priority->background_color=$request['background_color'];
            $priority->text_color=$request['text_color'];
            
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
