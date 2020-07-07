@extends('layouts.app')
@section('content_styles')
<style>
<?php
foreach(\App\Priority::get() as $priority)
{
    echo PHP_EOL .'.' . $priority->name .
            '{'. 
            'background-color: '. $priority->background_color .';'.
            'color: '. $priority->text_color .';'.
            '}' ;
}
?>
</style>
@endsection
@section('content')

{{ Form::model(null, array('id'=>'searchform', 'route' => array('tasks.tags'), 'method' => 'POST')) }}


<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>Search Tags</h3>
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a>
<a href="{{ route('tasks.create') }}" class="btn btn-primary float-right" style='margin-right: 10px'>Add Task</a>
<div class='clearfix'></div>
<div class="panel-body" >
<div class="row" >
    
    @if(Auth::user()->is_admin())    
        <div class="form-group">
        {{ Form::label('user_id', 'User', array('class'=>'')) }}
        {{ Form::select('user_id', $users, -1, array('class' => 'form-control', 'placeholder'=>'') ) }}        
        </div>
    @else
        {{ Form::hidden('user_id', Auth::user()->id) }}
    @endif
    <div class="form-group">
        @foreach($tags as $tag)
            <span class="w3-border w3-round" style="margin-left:5px"> {{ $tag[0] }}</span>&nbsp;
            @endforeach
        
    </div>    
    <div class="form-group">
        {{ Form::label('tag_search', 'Tags', array('class'=>'')) }}
        {{ Form::text('tag_search', null, array('class' => 'form-control') ) }}        
    </div>
    
    <div class="col-md-3 col-md-offset-1" >
    {{ Form::submit('Search', array('class' => 'btn btn-primary', 'style'=>'width:100%;height:50px;margin-top:20px', 'id'=>'btn_search_packages')) }}
    {{ Form::close() }}
    </div>
        
</div>
    
<hr>
<div class="row" style="width:100%;margin-top: 20px;">
<ul class="list-group col-md-12" style="width:100%">
    <li class="list-group-item "></li>
    @foreach ( $tasks as $task )
    <li class="list-group-item" style="width: 100%">
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

<div class="row text-center">
    {!! $tasks->appends(Request::all())->render() !!}
</div>

</div>

</div>
</div>
</div>

@endsection