@extends('layouts.app')
@section('content')

{{ Form::open(array('route' => 'tasks.store', 'method' => 'post')) }}



<div class="container">

    
<div class="panel panel-default">
<div class="panel-heading"><h3>Create New Task
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
        {{ Form::label('tzone', 'Time Zone', array('class'=>'')) }}
        {{ Form::text('tzone', 'UTC', array('readonly', 'class' => 'form-control')) }}
    </div>
</div>
</div>
<div class="row" style="width:100%">        
<div class="col-md-12" >    
    
<div class="form-group">
        {{ Form::label('priority_id', 'Priority', array('class'=>'')) }}
        {{ Form::select('priority_id', $priorities, -1, array('required', 'id'=>'priority_id', 'class' => 'form-control') ) }}        
</div>
<div class="form-group">
        {{ Form::label('status_id', 'Status', array('class'=>'')) }}
        {{ Form::select('status_id', $statuses, -1, array('required','id'=>'status_id', 'class' => 'form-control') ) }}        
</div>

<div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('required', 'class' => 'form-control')) }}
</div>

<div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', null, array('class' => 'form-control')) }}
</div>


    {{ Form::submit('Create Task', array('class' => 'btn btn-primary')) }}
    

</div>
</div>
</div>
</div>
</div>
</div>
{{ Form::close() }}

@endsection


@section('content_styles')

@endsection


@section('content_scripts')

<script type="text/javascript" src="{{asset('js/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/moment/moment-timezone-with-data.js')}}"></script>

<script type="text/javascript" src="{{asset('js/tempusdominus-bootstrap-4.min.js')}}"></script>


<script>

var dtpicker=null;
$(document).ready(function(){
 dtpicker = $('#datetimepicker1').datetimepicker({
   //format:'DD/MM/YY h:m A'
});

 var tz = moment.tz.guess();
 $("#tzone").val(tz);
$("form").submit(function(){
});

});

</script>
@endsection

