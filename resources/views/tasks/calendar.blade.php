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

.w3-card,.w3-card-2
{
    background: white;
    opacity: 1.0;
    filter: alpha(opacity=100);
    opacity:1!important;
    box-shadow:0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)
}
.w3-card-4,.w3-hover-shadow:hover{opacity:1!important;box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19)}
.w3-ul{list-style-type:none;padding:0;margin:0}.w3-ul li{padding:8px 16px;border-bottom:1px solid #ddd}.w3-ul li:last-child{border-bottom:none}
.w3-tooltip,.w3-display-container{position:relative}.w3-tooltip .w3-text{display:none}.w3-tooltip:hover .w3-text{display:inline-block}
.w3-ul.w3-hoverable li:hover{background-color:#ccc}.w3-centered tr th,.w3-centered tr td{text-align:center}
</style>


@endsection

@section('content_scripts')
<script type="text/javascript" src="{{asset('libs/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('libs/moment/moment-timezone-with-data.js')}}"></script>
<script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
<script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>

<script src="{{ asset('libs/fullcalendar-5.1.0/lib/main.js') }}" ></script>


<script>

function flag(task)
{
    return '<i class="fa fa-flag" aria-hidden="true" title="'+task.priority +'" style="background-color: ' + task.background_color +'!important;"></i>';
}


function create_tooltip(task)
{
    //console.log(task);
    tooltip=
        '<div class="text-dark" style="width: 18rem;color:black !important">'+
        '<ul class="w3-ul">'+
        '<li>'+flag(task)+' '+task.task_title+'</li>'+
        '<li>'+task.description+'</li>'+
        '<li>'+moment(task.due).format("lll")+'</li>'+
        '</ul>'+
        '</div>';
    return tooltip;
}
    
  document.addEventListener('DOMContentLoaded', function() 
  {
    var calendarEl = document.getElementById('calendar');
    jsn_tasks = {!! json_encode($tasks); !!};
//    
//    jsn_tasks.forEach(function (task) { 
//            task.tooltip=create_tooltip(task); 
//        }); 
        
    var calendar = new FullCalendar.Calendar(calendarEl, {
//      plugins: [ interactionPlugin ],
//      initialDate: '2020-06-12',
//      editable: true,
//      selectable: true,
//      businessHours: true,
//      dayMaxEvents: true, // allow "more" link when too many tasks
//      
//            
        "events": jsn_tasks,
        
        dateClick: function(date, jsEvent, view)
        {
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
            var tooltip = create_tooltip(info.event.extendedProps);//.description;
            //$(info.el).attr("data-original-title", tooltip)
            //$(info.el).tooltip({ container: "body"})
            $(info.el).tooltip({title: tooltip,
                  container: 'body',
                  html:true,
                  placement:"left",
                  template:'<div class="tooltip "  role="tooltip">\n\
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

