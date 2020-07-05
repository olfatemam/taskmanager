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
<div class="md-col-12" >    

<div class="form-group">
{{ Form::label('name', 'Name') }}
{{ Form::text('name', null, array('class' => 'form-control')) }}
</div>
    
<div class="form-group">
{{ Form::label('number', 'Number') }}
{{ Form::number('number', null, array('class' => 'form-control', 'required', 'min'=>1,'max'=>10 )) }}
</div>
    
<div class="form-group">
{{ Form::label('background_color', 'Background Color') }}
{{ Form::color('background_color', null, array('class' => 'form-control', 'required')) }}
</div>

<div class="form-group">
{{ Form::label('text_color', 'Text Color') }}
{{ Form::color('text_color', null, array('class' => 'form-control', 'required')) }}
</div>

{{ Form::submit('Create Priority', array('class' => 'btn btn-primary')) }}

</div>
</div>
</div>
</div>
</div>
</div>

{{ Form::close() }}
    
@endsection