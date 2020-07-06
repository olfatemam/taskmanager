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
<script type="text/javascript" src="{{asset('libs/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('libs/moment/moment-timezone-with-data.js')}}"></script>

<script src="{{ asset('libs/fullcalendar-5.1.0/lib/main.js') }}" ></script>


<script>

function create_tooltip(data)
{
    var style="text-align:center;color:" + data.text_color + ";background:"+ data.background_color+";";
    
    var tooltip = "<div class='card border' style='text-align:left;margin:0;padding:0;width:100%'>";
    
    tooltip +="<table class='table table-striped active table-sm'>";
    tooltip +="<tr><td colspan='2' style='" + style + "'>" +data.priority+ "(id="+data.id+")</td></tr>";
    tooltip +="<tr><td style='text-align:center'>"+data.duration+" min.</td>";
    tooltip +="<td style='text-align:center'>" + data.title +"</td></tr>";
    tooltip +="<tr><td><i class='fas fa-chalkboard-teacher'></i></td><td>"+ data.user_name+"</td></tr>";
    tooltip +="<tr><td><i class='fa fa-hourglass-start' aria-hidden='true'></i></td><td>"+moment(data.start).format("lll")+ "</td></tr>";
    tooltip += '</table></div>';
    return tooltip;
}
    
    //echo json_encode($tasks);
    
  document.addEventListener('DOMContentLoaded', function() 
  {
    var calendarEl = document.getElementById('calendar');
    jsn_tasks = {!! json_encode($tasks); !!};
    
    jsn_tasks.forEach(function (task) { 
            task.tooltip=create_tooltip(task); 
        }); 
        
    var calendar = new FullCalendar.Calendar(calendarEl, {
      //plugins: [ interactionPlugin ],
      initialDate: '2020-06-12',
      editable: true,
      selectable: true,
      businessHours: true,
      dayMaxEvents: true, // allow "more" link when too many tasks
      
            
        "events": jsn_tasks,
        
        dateClick: function(date, jsEvent, view)
        {
        },
        eventClick:function(event)
        {
            task=event.event;
            console.log(task);
            //alert(task.name);
            task_edit = "{{route('tasks.edit', -1)}}";
            if (task.id) {
                url = task_edit.replace("-1", task.id);
                window.open(url);
                return false;
            }
        },
//        eventRender: function(info)
//        {
//            $(info.el).tooltip
//            ({
//                        title: info.event.extendedProps.tooltip,
//                        container: 'body',
//                        html:true,
//                        placement:"left",
//                        template:'<div class="tooltip"  role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner" style="margin:0;padding:0;"></div></div>',
//                        delay: { "show": 500, "hide": 300 }
//            });
//        }        
    });

    calendar.render();
  });
  

</script>
@endsection