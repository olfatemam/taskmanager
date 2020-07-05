<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function search()
    {
        $statuses = Status::get();
        return view('statuses.search', compact('statuses'));
    }
    public function index()
    {
        return $this->search();
    }


    public function create()
    {
        return view('statuses.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
                    'name'=>'required|max:100',
        ]);
        try
        {
            $status = Status::create(
                    [
                        'name'=>$request['name'], 
                        'reminder'=>$request['reminder']
                        ]);
            return redirect()->route('statuses.search');//->with('flash_message', 'Task '. $status->name.' created');
        }
        catch (\PDOException $e)
        {
            return \App\Helpers\DBError::report($e);
        }
    }

    public function show(Status $status)
    {
        return view ('statuses.show', compact('status'));

    }


    public function edit(Status $status)
    {
        return view('statuses.edit', compact('task'));
    }


    public function update(Request $request, Status $status)
    {
        $this->validate($request, [
            'name'=>'required|max:200',
        ]);

        try
        {
            $status->name=$request['name'];
            
            $status->save();

            return redirect()->route('statuses.search', $status->id)->with('flash_message', 'Status, '. $status->name.' updated');
        }
        
        catch (\PDOException $e)
        {
            return \App\Helpers\DBError::report($e);
        }
    }


    public function destroy(Status $status)
    {
        $status->delete();
        return redirect()->route('statuses.search')->with('flash_message', 'Status deleted!');
    }
}
