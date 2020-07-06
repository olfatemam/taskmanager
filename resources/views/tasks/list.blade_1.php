@extends('layouts.app')

@section('content')

{{ Form::model(null, array('id'=>'searchform', 'route' => array($route), 'method' => 'POST')) }}


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
<ul class="list-group">
  <li class="list-group-item">Dapibus ac facilisis in</li>

  
  <li class="list-group-item list-group-item-primary">This is a primary list group item</li>
  <li class="list-group-item list-group-item-secondary">This is a secondary list group item</li>
  <li class="list-group-item list-group-item-success">This is a success list group item</li>
  <li class="list-group-item list-group-item-danger">This is a danger list group item</li>
  <li class="list-group-item list-group-item-warning">This is a warning list group item</li>
  <li class="list-group-item list-group-item-info">This is a info list group item</li>
  <li class="list-group-item list-group-item-light">This is a light list group item</li>
  <li class="list-group-item list-group-item-dark">This is a dark list group item</li>
</ul>
    
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
                    <th>Complete</th>
                    <th>Name</th>
                    <th>Due</th>
                    <th>Overdue</th>
                    <th>Priority</th>
                    <th>Reminder</th>
                    <th>Description</th>
                    
                </tr>
            </thead>

            <tbody>
                @foreach ($tasks as $task)
                <tr style="background:{{$task->priority->background_color}}; color: {{$task->priority->text_color}}" >
                    <td><a style="color: white" class="table-primary" href="{{route('tasks.complete', $task->id) }}"><i class="fa fa-check" aria-hidden="true"></i></a></td>
                    <td><a style="color: white;" href="{{route('tasks.show', $task->id) }}">{{$task->name}}</a></td>
                    <td>{{ $task->hagar_due() . ' ' }}</td>
                    <td>{{ $task->overdue()? 'YES':'FALSE' }}</td>
                    <td>{{ $task->priority->name }}</td>
                    <td>{{ ($task->reminder)?'YES':'NO' }}</td>
                    <td>{{ $task->description }}</td>
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