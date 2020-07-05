@extends('layouts.app')

@section('title', '| Create New User')

@section('content')
{{ Form::open(array('route' => 'users.store', 'method' => 'post')) }}



<div id="content">
<div class="container">
<div class="row">
        <div class="manage-catg">

        <a href="{{ url()->previous() }}" class="btn btn-primary float-right">Back</a>
        <a href="{{ route('projects.search') }}" class="btn btn-default float-right">Projects</a>
        <a href="{{ route('users.search') }}" class="btn btn-success float-right">Users</a>

    </div>
</div>
<div class="row">
<div class="span8">
<h1><span><br><b>Create User</b></span></h1>

    <div class="row">
    <div class="row">
    <div class="span8">
            <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', '', array('class' => 'form-control')) }}<br>
            </div>
            <div class="form-group">
            {{ Form::label('email', 'Email') }}
            {{ Form::text('email', '', array('readOnly', 'class' => 'form-control')) }}<br>
            </div>
            <div class="form-group">
            {{ Form::label('role', 'Role') }}
            {{ Form::select('role', array('User' => 'User', 'Admin' => 'Admin'), 'User', array('readOnly', 'class' => 'form-control')) }}<br>
            </div>
        
            
            {{ Form::submit('Create User', array('class' => 'btn btn-success btn-lg btn-block')) }}

    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
{{ Form::close() }}
    
@endsection