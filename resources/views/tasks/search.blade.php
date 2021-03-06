@extends('layouts.app')

@section('content_styles')
@include('tasks.includes.styles')
@endsection

@section('content')

{{ Form::model(null, array('id'=>'searchform', 'route' => array('tasks.search', $filter), 'method' => 'POST')) }}



<div class="w3-container w3-padding w3-card">
@include('tasks.includes.header', ['title'=>$filter])

<div class="w3-padding w3-panel">

    
@include('tasks.includes.control')

@if($rows_style=='table')
    @include('tasks.includes.rows_table', ['tasks'=>$tasks])
@else
    @include('tasks.includes.rows_ul', ['tasks'=>$tasks])
@endif

</div>
</div>


{{ Form::close() }}
@endsection