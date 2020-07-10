@extends('layouts.app')
@section('content_styles')


<link href="{{ asset('libs/fullcalendar-5.1.0/lib/main.css') }}" rel='stylesheet' />

<style>
.tooltip-inner 
{
  padding: 0;
  color: black;
  text-align: center;
  background-color: white;
  border-radius: 0rem;
  margin: 10px;
  padding:10px !important;
  font-weight: normal;
  font-size: medium;
  font-family: sans-serif;
  text-align: left !important;
  width:300px;
} 

.dayClickWindow,eventClickWindow
{
  width: 500px;
  height: 500px;
  border-radius: 15px;
  background-color: #000;
  position: absolute;
  left: 50%;
  top: 50%;
  margin-top: -250px;
  margin-left: -250px;
  display: none;
  z-index: 1;
}

</style>


@section('content')

<div class="container">
<div class="panel panel-default">
<div class="panel-body" >
    
@include ('tasks.includes.calendar')

</div>
</div>
</div>
@endsection


@endsection


@section('content_scripts')

@include ('tasks.scripts.calendar')

@endsection
