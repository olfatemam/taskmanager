@extends('layouts.app')
@section('title', '| Edit Task')
@section('content')

{{ Form::model($task, array('route' => array('tasks.update', $task->id), 'method' => 'PUT')) }}


<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>Create New Task</h3>
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a>
<div class='clearfix'>
</div>

<div class="panel-body" >

<div class="form-group">
        <div class='col-sm-6'>
            <div class="form-group">
                <div class='input-group date' id='due_datetimepicker'>
                    <input type='text' id="due" class="form-control" value="{{$task->due}}"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    
        </div>
    
<div class="form-group">
        {{ Form::label('priority_id', 'Priority', array('class'=>'')) }}
        {{ Form::select('priority_id', $priorities, $task->priority_id, array('id'=>'priority_id', 'class' => 'form-control') ) }}        
</div>
<div class="form-group">
        {{ Form::label('status_id', 'Status', array('class'=>'')) }}
        {{ Form::select('status_id', $statuses, $task->status_id, array('id'=>'status_id', 'class' => 'form-control', 'placeholder'=>'') ) }}        
</div>

<div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', $task->name, array('class' => 'form-control')) }}
</div>
    

<div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', $task->description, array('class' => 'form-control')) }}
</div>


    {{ Form::submit('Update Task', array('class' => 'btn btn-primary')) }}
    
</div>
</div>
</div>
</div>


{{ Form::close() }}
@endsection

@section('content_scripts')
<script>
$( document ).ready(function() {
$('#due_datetimepicker').datetimepicker({ format: 'YYYY-MM-DD hh:mm A' });

});

</script>
@endsection

