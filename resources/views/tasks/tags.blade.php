@extends('layouts.app')

@section('content_styles')
@include('tasks.includes.styles')
@endsection

@section('content')

{{ Form::model(null, array('id'=>'searchform', 'route' => array('tasks.tags'), 'method' => 'POST')) }}

<div class="w3-container w3-padding w3-card">
@include('tasks.includes.header', ['title'=>'Search by Tags'])

<div class="w3-padding w3-panel">
    
@include('tasks.includes.bytagscontrol')

<div class="w3-row">
<ul class="w3-ul w3-border-0" style="border: none">
    @foreach ( $tasks as $task )
    <li class="list-group-item w3-padding" style="width: 100%">
        <a title="finish" class="btn-edit btn-primary col-md-1 {{$task->priority->name}}" href="{{route('tasks.complete', $task->id) }}"><i class="fa fa-check" aria-hidden="true"></i></a>
        <a title="edit" class="col-md-1 btn-edit btn-primary  {{$task->priority->name}}" href="{{route('tasks.edit', $task->id) }}"><i class="fa fa-edit" aria-hidden="true"></i></a>
        
        
        <span class="col-md-2">{{ $task->hagar_due() . ' ' }}</span>
        
        <a class="col-md-3" href="{{route('tasks.show', $task->id) }}">{{$task->name }}</a>
        {!!$task->tags()!!}
        {!!$task->state()!!}
                
    </li>
  
  @endforeach
</ul>
</div>

<div class="w3-row w3-center">
    {!! $tasks->appends(Request::all())->render() !!}
</div>

</div>
</div>


{{ Form::close() }}
@endsection
