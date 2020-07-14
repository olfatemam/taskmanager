<script type="text/javascript" src="{{asset('libs/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('libs/moment/moment-timezone-with-data.js')}}"></script>

<script src="{{ asset('libs/fullcalendar-5.1.0/lib/main.js') }}" ></script>


<script>
var calendar=null;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

function on_dateClick(start, event)
{
    console.log('input date='+start +" " );
    if(event)
    {
        //document.getElementById("due").value = moment.utc(event.extendedProps.due).tz(moment.tz.guess()).format('YYYY-MM-DD HH:mm:ss');
        document.getElementById("due").value = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
    }
    else
    {
        document.getElementById("due").value = moment(start).format('YYYY-MM-DD HH:mm:ss');
    }
    document.getElementById("timezone").value = moment.tz.guess();
    
    $("#datetimezone").text ( document.getElementById("due").value + " " + moment.tz.guess());
    
    if(event)
    {
        $("#newtask-form-submit").val("Update Task");
        $("#task_id").val(event.id);
        $("#name").val(event.title);
        $("#description").val(event.extendedProps.description);
        $("#priority_id").prop('checked', event.extendedProps.priority_id);
        $("#reminder").prop('checked', event.extendedProps.reminder);
        $("#completed").prop('checked', event.extendedProps.completed);
    }
    else
    {
        $("#task_id").val(-1);
        $("#name").val("");
        $("#description").val("");
        $("#priority_id").prop('checked', false);
        $("#reminder").prop('checked', true);
        $("#completed").prop('checked', false);
        
        $("#completed_div").hide();
    }
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
                    
                    utc = moment.utc(task.due);
                    task.start=utc.local().format();

                    task.priority=task.priority_name;
                    task.status=task.status_name;
                    task.user=task.user_name;
                    console.log(task);    
                    
                    if(task.is_new==false)
                    {
                        event = g_calendar.getEventById(task.id);
                        event.remove();
                    }
                    var ret = g_calendar.addEvent(
                    {
                                id: task.id,
                                title: task.name,
                                due: task.due,
                                start: task.start,
                                end: task.end,
                                
                                priority: task.priority_name,
                                status: task.status_name,
                                user_name: task.user_name,
                                color: task.color,
                                completed: task.completed,
                                description: task.description,
                                timezone: task.timezone,
                                user_id: task.user_id
                    });
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

    jsn_tasks.forEach(function (task)
    {
        utc = moment.utc(task.due);
        task.start=utc.local().format();
        
        //        .tz(moment.tz.guess());
        
        console.log(task.start);
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
        
        dateClick: function(arg, jsEvent, view)
        {
            cdate  = moment(arg.date);
            on_dateClick(cdate, null);
        },

        eventClick:function(arg)
        {
            console.log(arg.event.start);
            on_dateClick(arg.event.start, arg.event);
        },
        eventDidMount: function (info)
        {
            init_tooltip(info);
        },
});

    g_calendar.render();
});
  

</script>
