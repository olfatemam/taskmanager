@extends('layouts.app')
@section('title', '| Edit Task')

@section('content_styles')
<style>
<?php
foreach(\App\Priority::get() as $priority)
{
    echo PHP_EOL .'.' . $priority->name .
            '{'. 
            'background-color: '. $priority->background_color .';'.
            'color: '. $priority->text_color .';'.
            '}' ;
}
?>
    
</style>
@endsection

@section('content')



{{ Form::model(null, array('route' => array('tasks.update', $task), 'method' => 'PUT')) }}
{{ Form::hidden('timezone', "UTC", array('id'=>'timezome') ) }}

<div class="container">

    
<div class="panel panel-default">
<div class="panel-heading"><h5>Edit Task
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a>
            <span name='timezone_text' id='timezone_text' class ='btn btn-info float-right' >UTC</span>
    </h5>
        {{ Form::text('timezone', 'UTC', array('readonly', 'class' => 'w3-btn float-right')) }}
<div class='clearfix'></div>
</div>
<div class="panel-body w3-padding w3-border" style="margin-top: 20px">

<div class="row" style="width:100%">    
    
<div class="col-md-12" >    
<div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', $task->name, array('required', 'class' => 'form-control')) }}
</div>
</div>
</div>
    
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

</div>
<div class="row" style="width:100%">        
<div class="col-md-12" >    
    
<div class="form-group">
        {{ Form::label('priority_id', 'Priority', array('class'=>'')) }}
@foreach($priorities as $priority)
<input type="radio" id="priority_id" name="priority_id" value="{{$priority->id}}" {{ ( $priority->id==$task->priority_id )? "checked": "" }} >

<label class="{{$priority->name}}" for="priority_id">{{$priority->name}}</label>
@endforeach
</div>

<div class="form-group">
        <label for="description"><i class="fa fa-tags" aria-hidden="true">Keywords</i></label>
        {{ Form::text('description', $task->description, array('class' => 'form-control')) }}
</div>
    

<div class="form-group row">
    <div class="col-md-1" style='padding: 0;margin:0'>{{ Form::checkbox('reminder', 1, $task->reminder, array('id'=>'reminder', 'class' => 'form-control', 'style'=>'margin-right:0')) }}</div>        
    <div class="col-md-2" >{{ Form::label('reminder', 'Send Reminder', array('style'=>'')) }}</div>        
</div>
<div class="form-group row">
    <div class="col-md-1" style='padding: 0;margin:0'>{{ Form::checkbox('completed', 1, $task->completed, array('id'=>'completed', 'class' => 'form-control', 'style'=>'margin-right:0')) }}</div>        
    <div class="col-md-2" >{{ Form::label('completed', 'Completed', array('style'=>'')) }}</div>        
</div>
    <hr>


    {{ Form::submit('Update Task', array('class' => 'btn btn-primary')) }}
    

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
    $('#completed').change(function() {
        if(this.checked) {
            $('#reminder').prop( "checked", false);
        }
});
    $('#reminder').change(function() {
        if(this.checked) {
        $('#completed').prop( "checked", false);
    }
});
            

 var tz = moment.tz.guess();
    $("#timezone").val(tz);
    $("#timezone_text").text(tz);
    
    //var due = moment("{{$task->due}}", "UTC");
    var due = "{{$task->due}}";
    
    $('#datetimepicker1').datetimepicker({
        date: due,
    });
 
    $("form").submit(function(){
   });
});

</script>
@endsection
