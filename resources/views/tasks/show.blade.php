@extends('layouts.app')

@section('title', '| View Task')

@section('content')

<div class="x_panel">
    <div class="x_title">
        View Task
<a href="{{ url()->previous() }}" class="nav-item nav-link  float-right">Back</a>
    @role('Admin')
    <a href="{{ route('tasks.edit', $task->id) }}"  class="btn btn-edit float-right"><i class="fa fa-edit"></i></a>
    @endrole
    
    <div class='clearfix'></div>
    </div>
    <div class="x_content">
        <br>    
        <div class="row">
            <h3>{{ 'Name: '. $task->name }}</h3>
            <hr>
        </div>
    </div>
</div>

@endsection