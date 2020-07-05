@extends('layouts.app')

@section('content')

<div class="container">
<div class="panel panel-default">
<div class="panel-body" >
<div id='calendar'></div>

</div>
</div>
</div>
@endsection


@section('content_styles')


<link href="{{ asset('libs/fullcalendar-5.1.0/lib/main.css') }}" rel='stylesheet' />

<style>

tooltip > .tooltip-inner {
  background: white;
  opacity: 1.0;
  filter: alpha(opacity=100);
} 
.tooltip.in{opacity:1!important;}

</style>

@endsection

@section('content_scripts')
<script src="{{ asset('libs/fullcalendar-5.1.0/lib/main.js') }}" ></script>


<script>
    
    //echo json_encode($tasks);
    
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialDate: '2020-06-12',
      editable: true,
      selectable: true,
      businessHours: true,
      dayMaxEvents: true, // allow "more" link when too many events
      
            
        events: {!! json_encode($tasks); !!}
        
    });

    calendar.render();
  });

</script>
@endsection