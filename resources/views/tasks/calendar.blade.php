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


@section('content')

<div class="container">
<div class="panel panel-default">
<div class="panel-body" >
<div id='calendar'></div>

@include ('tasks.includes.calendar_modal')

</div>
</div>
</div>
@endsection


@endsection


@section('content_scripts')

<script type="text/javascript" src="{{asset('libs/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('libs/moment/moment-timezone-with-data.js')}}"></script>


<script src="{{ asset('libs/fullcalendar-5.1.0/lib/main.js') }}" ></script>


<script>
    
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



function on_dateClick(date, jsEvent, view)
{
    cdate = moment(date.date).local();
    
    document.getElementById("due").value = cdate.format('YYYY-MM-DD HH:mm:ss');
    document.getElementById("timezone").value = moment.tz.guess();
    $('#mymodal').modal();
}

$(function()
{
    $('#newtask-form-submit').on('click', function(e)
    {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url:"{{ route('tasks.store_from_calendar') }}",
            data: $('form.tagForm').serialize(),
            success: function(response)
            {
                if(response.success)
                {
                    task = response.success;
                    task.title=task.name;
                    task.due = moment.utc(task.due);
                    task.start=task.due;
                    task.end=task.due;
                    task.end.add(30, 'minutes');
                    //task.color=task.priority.background_color;
                    task.priority=task.priority_name;
                    task.status=task.status_name;
                    //task.user_name=task.user.name;
                    task.user=task.user_name;
                    //task.allDay=true;
                    
                    console.log(task);    
                    
                    
                    var ret = g_calendar.addEvent(
                        {
                            id: task.id,
                            title: task.title,
                            start: task.due.format(),
                            end:    task.end.format(),
                            priority: task.priority,
                            status: task.status,
                            user_name: task.user_name,
                            color: task.color,
                            completed: task.completed,
                            description: task.description,
                            timezone: task.timezone,
                            user_id: task.user_id
                        }
                        );
                        g_calendar.render();
                }
                else if(response.error)
                {
                    alert('Error: ' + response.error);
                }
            },
            error: function(response) {
                alert(response);
            }
        });
        $("#mymodal").modal("toggle");
        return false;
    });
});


        
var calendar=null;

function on_event_click(event)
{
    task=event.event;
    task_edit = "{{route('tasks.edit', -1)}}";
    if (task.id) {
        url = task_edit.replace("-1", task.id);
        window.open(url);
        return false;
   }
}

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
function init_tooltip(info)
{
    var tooltip = create_tooltip(info.event);//.description;
    $(info.el).tooltip({
                            title: tooltip,
                            container: 'body',
                            html:true,
                            placement:"left",
                            template:'<div class="tooltip"  role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner w3-card" style="margin:0;padding:0;"></div></div>',
                            delay: { "show": 500, "hide": 300 }
                        });
}
    
document.addEventListener('DOMContentLoaded', function() 
{
    var calendarEl = document.getElementById('calendar');
    jsn_tasks = {!! json_encode($tasks); !!};

    jsn_tasks.forEach(function (task) {
        task.start = moment(task.due, 'UTC');
        task.start = task.due;//, 'UTC');
    });
    
    g_calendar = new FullCalendar.Calendar(calendarEl, 
    {
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
        navLinks: true, // can click day/week names to navigate views
        businessHours: true, // display business hours
        editable: true,
        selectable: true,

        "events": jsn_tasks,

        dateClick: function(date, jsEvent, view)
        {
            on_dateClick(date, jsEvent, view);
        },

        eventClick:function(event)
        {
            on_event_click(event);

        },
        eventDidMount: function (info)
        {
            init_tooltip(info);
        },
});

    g_calendar.render();
});
  

</script>
@endsection

