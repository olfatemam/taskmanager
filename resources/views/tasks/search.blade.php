@extends('layouts.app')

@section('content')

{{ Form::model(null, array('id'=>'searchform', 'route' => array('tasks.search'), 'method' => 'POST')) }}


<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>Tasks</h3>
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a>
<a href="{{ route('tasks.create') }}" class="btn btn-primary float-right" style='margin-right: 10px'>Add Task</a>
<div class='clearfix'></div>
<div class="panel-body" >
<div class="row" >
    @if(Auth::user()->is_admin())    
    <div class="col-md-3">
        {{ Form::label('user_id', 'User', array('class'=>'')) }}
        {{ Form::select('user_id', $users, -1, array('class' => 'form-control', 'placeholder'=>'') ) }}        
    </div>
    @else
        {{ Form::hidden('user_id', Auth::user()->id) }}        
    @endif
    <div class="col-md-3">
        {{ Form::label('priority_id', 'Priority', array('class'=>'')) }}
        {{ Form::select('priority_id', $priorities, -1, array('id'=>'priority_id', 'class' => 'form-control', 'placeholder'=>'') ) }}        
    </div>

    <div class="col-md-3 col-md-offset-1" >
    {{ Form::submit('Search', array('class' => 'btn btn-primary', 'style'=>'width:100%;height:50px;margin-top:20px', 'id'=>'btn_search_packages')) }}
    {{ Form::close() }}
    </div>
        
</div>
    


<div class="row">
<div class="col-md-12">
    
<div class=''>Page {{ $tasks->currentPage() }} of {{ $tasks->lastPage() }}
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="table-responsive">
        <table class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Due</th>
                    
                    <th>Priority</th>
                    <th>Completed</th>
                    <th>Reminder</th>
                    <th>Description</th>
                    <th>Operations</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td><a href="{{route('tasks.show', $task->id) }}">{{$task->id}}</a></td>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->due . ' '. $task->timezone }}</td>
                    <td>{{ $task->priority->name }}</td>
                    <td>{{ ($task->completed)?'YES':'NO' }}</td>
                    <td>{{ ($task->reminder)?'YES':'NO' }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-edit pull-left" style="margin-right: 3px;">Edit</a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['tasks.destroy', $task] ]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>


</div>
</div>
</div>
</div>
</div>
</div>

@endsection