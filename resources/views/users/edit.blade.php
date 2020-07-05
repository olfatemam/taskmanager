@extends('layouts.app')

@section('title', '| Edit User')

@section('content')

<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><b>Edit User</b>
        <a href="{{ url()->previous() }}" class="btn btn-primary float-right" style='float: right'>Back</a>
        <a href="{{ route('users') }}" class="btn btn-success float-right" style='float: right'>Users</a>
        <div class='clearfix'></div>
</div>

<div class="panel-body">

{{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}

            <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', $user->name, array('class' => 'form-control')) }}
            </div>

        <div class="form-group">
            {{ Form::label('email', 'Email') }}
            {{ Form::text('email', $user->email, array('readOnly', 'class' => 'form-control')) }}<br>
            </div>
            <div class="form-group">
            {{ Form::label('role', 'Role') }}
            {{ Form::select('role', array('User' => 'User', 'Admin' => 'Admin'), $user->role, array('class' => 'form-control')) }}<br>
            </div>
        
            
            {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
            {{ Form::close() }}
    
</div>
</div>
</div>
@endsection