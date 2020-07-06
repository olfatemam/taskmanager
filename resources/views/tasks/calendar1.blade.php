@extends('layouts.app')

@section('content')

<div class="container">
<div class="panel panel-default">
<div class="panel-body" >
<div class='w3-card w3-sand w3-border' style='text-align:left;margin:0;padding:0;width:100%'><table class='w3-table w3-table-all w3-small'><tr><td><i class="fa fa-flag" aria-hidden="true" style="color: #fd423f !important;"><s>test</s></i></td></tr><tr><td>test desc</td></tr><tr><td>Jul 5, 2020 7:47 PM</td></tr></table></div>
    
    
    <div id='calendar'></div>
</div>
</div>
</div>
@endsection


@section('content_styles')


<link href="{{ asset('libs/fullcalendar-5.1.0/lib/main.css') }}" rel='stylesheet' />
<link href="{{ asset('libs/w3.css') }}" rel='stylesheet' />


@endsection

@section('content_scripts')
<script type="text/javascript" src="{{asset('libs/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('libs/moment/moment-timezone-with-data.js')}}"></script>
<script src="{{ asset('libs/fullcalendar-5.1.0/lib/main.js') }}" ></script>

<style>

.tooltip-inner 
{
  max-width: 200px;
  padding: 0;
  color: purple;
  text-align: center;
  background-color: red;
  border-radius: 0rem;
  margin: 10px;
  padding:10px !important;
  font-weight: bold;
  font-size: large;
  font-family: sans-serif;
  text-align: left !important;
  min-width:200px;
  min-height:200px;
} 

</style>

<style>

/*tooltip > .tooltip-inner {
  opacity: 1.0;
  filter: alpha(opacity=100);
  min-width:200px;
} 

.tooltip.in{opacity:1!important;}*/

</style>

<script>

function flag(task)
{
    //if(task.completed==true)
    {
        return '<i class="fa fa-flag" aria-hidden="true" style="color: ' + task.background_color+' !important;">'+ '<s>' +task.task_title+'</s></i>';
    }
    //return '<i class="fa fa-flag" aria-hidden="true" title="'+ task.priority +'" style="background-color: ' + task.background_color +'!important;"><p>'+task.task_title+'</p></i>';
}




function create_tooltip(task)
{
    //console.log(task);
    var tooltip =   '<div class="" style=width:100%>'+
                    '<table class="w3-table w3-table-all">'+
                    '<tr><td>'+
                    flag(task)+
                    '</td></tr>'+
                    '<tr><td>' +
                        task.description+
                    '</td></tr>'  +
                    '<tr><td>'    +
                    moment(task.due).format("lll")+
                    '</td></tr>'+
                    '</table></div>';

    console.log(tooltip);
    return tooltip;
}
    
  document.addEventListener('DOMContentLoaded', function() 
  {
    var calendarEl = document.getElementById('calendar');
    jsn_tasks = {!! json_encode($tasks); !!};
        
    var calendar = new FullCalendar.Calendar(calendarEl, {
        "events": jsn_tasks,
        
        dateClick: function(date, jsEvent, view)
        {
        },
        eventClick:function(event)
        {
            task=event.event;
            task_edit = "{{route('tasks.edit', -1)}}";
            if (task.id) {
                url = task_edit.replace("-1", task.id);
                window.open(url);
                return false;
            }
        },
        eventDidMount: function (info) {
            $(info.el).tooltip({title: create_tooltip(info.event.extendedProps),
                  container: 'body',
                  html:true,
                  placement:"left",
                  template:'<div class="tooltip1"  role="tooltip"><div class="tooltip-arrow1"></div><div class="tooltip-inner"></div></div>',
                  delay: { "show": 500, "hide": 300 }
        });
            //console.log(info.event.extendedProps);
//            var tooltip = create_tooltip(info.event.extendedProps);//.description;
//            $(info.el).attr("data-original-title", tooltip)
//            $(info.el).tooltip({ container: "body"})
//            $(info.el).tooltip({title: tooltip,
//                  container: 'body',
//                  html:true,
//                  placement:"left",
//                  template:'<div class="tooltip"  role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner" style="margin:0;padding:0;"></div></div>',
//                  delay: { "show": 500, "hide": 300 }
//              });
           },
    });

    calendar.render();
  });
  

</script>
@endsection

