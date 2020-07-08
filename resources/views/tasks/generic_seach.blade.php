@extends('layouts.app')

@section('content_styles')
@include('tasks.includes.styles')
@endsection

@section('content')

{{ Form::model(null, array('id'=>'searchform', 'route' => array($route, $param), 'method' => 'POST')) }}



<div class="w3-container w3-padding w3-card">
@include('tasks.includes.header', ['title'=>$title])

<div class="w3-padding w3-panel">

    
@include('tasks.includes.control', ['search_tags'=>$search_tags, 'tags'=>$tags])
@if($rows_style=='table')
    @include('tasks.includes.rows_table', ['tasks'=>$tasks])
@else
    @include('tasks.includes.rows_ul', ['tasks'=>$tasks])
@endif

</div>
</div>


{{ Form::close() }}
@endsection