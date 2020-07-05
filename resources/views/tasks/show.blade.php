@extends('layouts.app')

@section('content')

<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>View Status</h3>
    
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a>

@if( Auth::user()->is_admin()==true )
    <a href="{{ route('tasks.edit', $task->id) }}"  class="btn btn-edit btn-success float-right" style='margin-right: 10px;'>Edit</a>
@endif
<div class='clearfix'>
</div>
</div>

<div class="panel-body" >
<div class="table-responsive " >
<table class='table table-striped'>
<tr>Id<td></td><td><a href="{{route('tasks.show', $task->id) }}">{{$task->id}}</a></td>
</tr><tr><td>Name</td><td>{{ $task->name }}</td>
</tr><tr><td>Due</td><td>{{ $task->due . ' '. $task->timezone }}</td>
</tr><tr><td>Status</td><td>{{ $task->status->name }}</td>
</tr><tr><td>Priority</td><td>{{ $task->priority->name }}</td>
</tr><tr><td>Reminder</td><td>{{ ($task->reminder)?'YES':'NO' }}</td>
</tr><tr><td>Description</td><td>{{ $task->description }}</td>
</tr>
</table>

</div>
</div>
</div>
</div>

@endsection