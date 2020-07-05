@extends('layouts.app')

@section('title', '| Create New Priority')

@section('content')
{{ Form::open(array('route' => 'priorities.store', 'method' => 'post')) }}
<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>Create New Priority
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a></h3>
<div class='clearfix'>
</div>

<div class="panel-body " style="margin-top: 20px">

<div class="row" style="width:100%">    

<div class="form-group">
{{ Form::label('name', 'Name') }}
{{ Form::text('name', null, array('class' => 'form-control')) }}
</div>

    {{ Form::submit('Create Priority', array('class' => 'btn btn-primary')) }}

</div>
</div>
</div>
</div>
</div>

{{ Form::close() }}
    
@endsection