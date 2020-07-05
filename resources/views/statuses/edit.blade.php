@extends('layouts.app')

@section('title', '| Edit Status')

@section('content')
{{ Form::model($status, array('route' => array('statuses.update', $status), 'method' => 'PUT')) }}

<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>Edit Status
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a></h3>
<div class='clearfix'>
</div>

<div class="panel-body " style="margin-top: 20px">

<div class="row" style="width:100%">    

<div class="form-group">
{{ Form::label('name', 'Name') }}
{{ Form::text('name', $status->name, array('class' => 'form-control')) }}
</div>
<div class="form-group row">
    <div class="col-md-1" style='padding: 0;margin:0'>{{ Form::checkbox('reminder', 1, $status->reminder, array('class' => 'form-control', 'style'=>'margin-right:0')) }}</div>        
    <div class="col-md-2" >{{ Form::label('reminder', 'Send Reminder', array('style'=>'')) }}</div>        
</div>
    
    {{ Form::submit('Update Status', array('class' => 'btn btn-primary')) }}

</div>
</div>
</div>
</div>
</div>

{{ Form::close() }}
@endsection