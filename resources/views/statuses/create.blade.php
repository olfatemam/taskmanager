@extends('layouts.app')

@section('title', '| Create New Status')

@section('content')
{{ Form::open(array('route' => 'statuses.store', 'method' => 'post')) }}

<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>Create New Status
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a></h3>
<div class='clearfix'>
</div>

<div class="panel-body " style="margin-top: 20px">

<div class="row" style="width:100%">    
<div class="col-md-12">    

<div class="form-group">
{{ Form::label('name', 'Name') }}
{{ Form::text('name', null, array('class' => 'form-control')) }}
</div>
<div class="form-group row">
    <div class="col-md-1" style='padding: 0;margin:0'>{{ Form::checkbox('reminder', 1, true, array('class' => 'form-control', 'style'=>'margin-right:0')) }}</div>        
    <div class="col-md-2" >{{ Form::label('reminder', 'Send Reminder', array('style'=>'')) }}</div>        
</div>

    {{ Form::submit('Create Status', array('class' => 'btn btn-primary')) }}

</div>
</div>
</div>
</div>
</div>
</div>

{{ Form::close() }}
    
@endsection