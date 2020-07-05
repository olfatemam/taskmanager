@extends('layouts.app')

@section('content')

<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>View User</h3>
    
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a>

@if( Auth::user()->is_admin()==true )
    <a href="{{ route('users.edit', $user->id) }}"  class="btn btn-edit btn-success float-right" style='margin-right: 10px;'>Edit</a>
@endif
<div class='clearfix'>
</div>
</div>

<div class="panel-body" >
<div class="table-responsive " >
    
    <table class='table table-striped'>
    <tr><th>Name</th><td>{{$user->name }}</td></tr>
    <tr><th>Email</th><td>{{$user->email }}</td></tr>
    <tr><th>Role</th><td>{{$user->role }}</td></tr>
</tr>
</div>
</div>
</div>
</div>

@endsection