@extends('layouts.app')
@section('title', '| Edit Task')
@section('content')

{{ Form::model($task, array('route' => array('tasks.update', $task), 'method' => 'PUT')) }}

<div class="container">

    
<div class="panel panel-default">
<div class="panel-heading"><h3>Edit New Task
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a></h3>
<div class='clearfix'>
</div>

<div class="panel-body " style="margin-top: 20px">


<div class="row" style="width:100%">    
    
<div class="col-md-6" >
    <div class="form-group">
        {{ Form::label('due', 'Due Date', array('class'=>'')) }}
    
        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
            <input required id="due" name="due" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
        </div>
    </div>
</div>
<div class="col-md-6" >
    <div class="form-group">
        {{ Form::label('timezone', 'Time Zone', array('class'=>'')) }}
        {{ Form::text('timezone', $task->timezone, array('readonly', 'class' => 'form-control')) }}
    </div>
</div>
</div>
<div class="row" style="width:100%">        
<div class="col-md-12" >    
    
<div class="form-group">
        {{ Form::label('priority_id', 'Priority', array('class'=>'')) }}
        {{ Form::select('priority_id', $priorities, $task->priority_id, array('required', 'id'=>'priority_id', 'class' => 'form-control') ) }}        
</div>
<div class="form-group">
        {{ Form::label('status_id', 'Status', array('class'=>'')) }}
        {{ Form::select('status_id', $statuses, $task->status_id, array('required','id'=>'status_id', 'class' => 'form-control') ) }}        
</div>

<div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', $task->name, array('required', 'class' => 'form-control')) }}
</div>

<div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', $task->description, array('class' => 'form-control')) }}
</div>
    

<div class="form-group row">
    <div class="col-md-1" style='padding: 0;margin:0'>{{ Form::checkbox('reminder', 1, $task->reminder, array('class' => 'form-control', 'style'=>'margin-right:0')) }}</div>        
    <div class="col-md-2" >{{ Form::label('reminder', 'Send Reminder', array('style'=>'')) }}</div>        
</div>
    <hr>


    {{ Form::submit('Update Task', array('class' => 'btn btn-primary')) }}
    

</div>
</div>
</div>
</div>
</div>
</div>
{{ Form::close() }}

@endsection


@section('content_styles')
<link href="{{ asset('libs/datetimepicker/css/tempusdominus-bootstrap-4.min.css') }}" rel='stylesheet' />
@endsection

@section('content_scripts')
<script type="text/javascript" src="{{asset('libs/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('libs/moment/moment-timezone-with-data.js')}}"></script>
<script type="text/javascript" src="{{asset('libs/datetimepicker/js/tempusdominus-bootstrap-4.min.js')}}"></script>


<script>


$(document).ready(function(){
    var tz = moment.tz.guess();
    
    $("#timezone").val(tz);

    var due = moment("{{$task->due}}");
    
    $('#datetimepicker1').datetimepicker({
        date: due,
    });
 
    $("form").submit(function(){

    });

});

</script>
@endsection
