@extends('layouts.app')

@section('content')

<div class="container">
<div class="panel panel-default">
<div class="panel-body" >
<div id='calendar'></div>

<div class="dayClickWindow">

</div>

<div class="eventClickWindow">
</div>

</div>
</div>
</div>
@endsection


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

/*.w3-card,.w3-card-2
{
    background: white;
    opacity: 1;
    box-shadow:0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)
}*/

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
<?php
foreach(\App\Priority::get() as $priority)
{
    echo PHP_EOL .'.' . $priority->name .'{'. 'color: '. $priority->background_color .';}' ;
}
?>

</style>

@endsection

@section('content_scripts')
<script type="text/javascript" src="{{asset('libs/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('libs/moment/moment-timezone-with-data.js')}}"></script>
<script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
<script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>

<script src="{{ asset('libs/fullcalendar-5.1.0/lib/main.js') }}" ></script>


<script>

function get_staus_title(event)
{
    
    overdue="";
    if(event.extendedProps.completed==true)
    {
         return '<span><s>'+event.title+'</s></span>';
    }
    if(moment(event.start).isBefore(moment())==true)
    {
        overdue=' <span class="rounded badge w3-yellow">Overdue</span>'
    }
    return '<span>'+event.title+overdue+'</span>';
}

function format_tags(tags_string)
{
    if(!tags_string)return "";
    
    $tags_html="";

    var tags_arr = tags_string.split(" ");
    tags_arr.forEach(function (tag) { 
            tags = tag.replace(/\s/g,'');
        $tags_html+='<i class="w3-border round badge">'+tag+'</i>&nbsp;';
    });
    return $tags_html;
}

function create_tooltip(event)
{
     task = event.extendedProps;
    tooltip=
        '<div class="w3-tooltip" >'+
        '<ul class="w3-ul">'+
        '<li><i class="fa fa-flag ' + task.priority + '" aria-hidden="true" ></i>'+' '+ 
        get_staus_title(event) +'</li>'+
        '<li>'+format_tags(task.description)+'</li>'+
//            '<li>'+moment.utc(task.due).tz(task.timezone).format("MMM Do, ddd h:m a")+' '+ task.timezone+'</li>'+
        '</ul>'+
        
        '</div>';
    return tooltip;
}
    
  document.addEventListener('DOMContentLoaded', function() 
  {
    var calendarEl = document.getElementById('calendar');
    jsn_tasks = {!! json_encode($tasks); !!};
    
    jsn_tasks.forEach(function (task) {
        task.start = moment(task.due, 'UTC');
        task.start = task.due;//, 'UTC');
    });
        
    var calendar = new FullCalendar.Calendar(calendarEl, 
    {
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    
    initialDate: '2020-06-12',
    navLinks: true, // can click day/week names to navigate views
    businessHours: true, // display business hours
    editable: true,
    selectable: true,

    "events": jsn_tasks,
        
        dateClick: function(date, jsEvent, view)
        {
            //$('.dayClickWindow').show();
        },
        eventClick:function(event)
        {
            task=event.event;
            //console.log(task);
            //alert(task.name);
            task_edit = "{{route('tasks.edit', -1)}}";
            if (task.id) {
                url = task_edit.replace("-1", task.id);
                window.open(url);
                return false;
            }
        },
        eventDidMount: function (info) {
            //console.log(info.event.extendedProps);
            var tooltip = create_tooltip(info.event);//.description;
            //$(info.el).attr("data-original-title", tooltip)
            //$(info.el).tooltip({ container: "body"})
            $(info.el).tooltip({title: tooltip,
                  container: 'body',
                  html:true,
                  placement:"left",
                  template:'<div class="tooltip"  role="tooltip">\n\
                <div class="tooltip-arrow"></div><div class="tooltip-inner w3-card" \n\
                        style="margin:0;padding:0;"></div></div>',
                  delay: { "show": 500, "hide": 300 }
            });
           },
//        
//      eventDidMount: function(info) 
//      {
//            var tooltip = info.event.description;
//            $(element).attr("data-original-title", tooltip)
//            $(element).tooltip({ container: "body"});
//            ////        var tooltip = new Tooltip(info.el, {
////                    title: info.event.extendedProps.description,
////                    placement: 'top',
////                    trigger: 'hover',
////                    container: 'body'
////                  });
//      
//      },

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

