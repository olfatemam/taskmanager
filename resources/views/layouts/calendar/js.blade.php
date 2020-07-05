
<script src="{{ asset('frontend/vendors/fullcalendar-4.4.0/packages/core/main.js') }}" ></script>
<script src="{{ asset('frontend/vendors/fullcalendar-4.4.0/packages/interaction/main.js') }}" ></script>
<script src="{{ asset('frontend/vendors/fullcalendar-4.4.0/packages/daygrid/main.js') }}" ></script>
<script src="{{ asset('frontend/vendors/fullcalendar-4.4.0/packages/timegrid/main.js') }}" ></script>
<script src="{{ asset('frontend/vendors/fullcalendar-4.4.0/packages/list/main.js') }}"></script>

<script type="text/javascript">
var g_coming_classes=null;
var g_pastclasses=null;
var g_triggered=false;

function load_user_children_list(user_id, $list_id)
{
    $("#"+$list_id).empty();
    $.get( "{{ env('APP_URL') }}"+"/ajax_user_children?user_id=" + user_id, function(users)
    {
        $.each(users, function( index, name ) {
            $("#"+$list_id).append(new Option(name, index)); 
        });
        $("#"+$list_id).trigger('change');
        
    });
}

function cal_addEventSource(calendar, nevents)
{
    
    if(nevents.length>0)
    {
        for(var i=0;i<nevents.length; i++)
        {
            
            nevents[i].org_utc_start=nevents[i].start;
            
            var utc_start=moment.tz(nevents[i].org_utc_start, 'UTC');
            
            var utc_end = utc_start;
            utc_end=utc_end.add(nevents[i].duration, 'minutes');
            
           nevents[i].org_utc_end=utc_end;
           nevents[i].utc_start    =   utc_start;//.format("YYYY-MM-DD h:mm A");
           nevents[i].utc_end      =   utc_end;//.format("YYYY-MM-DD h:mm A");
            
            var client = nevents[i].client;
            if(client==null|| client=="null")client="unassigned";
            if
            (nevents[i].combinedstudents!=null)
                client= '['+nevents[i].combinedstudents+']';
                
            nevents[i].tooltip_title    =   nevents[i].title;
            
            nevents[i].title    =   client;
            
            
            var tzstart = moment.tz(nevents[i].org_utc_start, 'UTC');
            tzstart.tz( moment.tz.guess());
            
            
            nevents[i].start = tzstart.format();//"YYYY-MM-DD h:mm A");
            
            var tzend = moment.tz(utc_end.format(), 'UTC');
            tzend.tz( moment.tz.guess());
            
            nevents[i].end = tzend.format();//"YYYY-MM-DD h:mm A");
            nevents[i].description = create_tooltip(nevents[i]);
            
            if(nevents[i].duration!=60)
            {
                console.log('found one');
                console.log("start="+nevents[i].start);
                console.log("end="+nevents[i].end);
                console.log("duration="+nevents[i].duration);
                //console.log(nevents[i]);
            }
            
        }
        calendar.addEventSource(nevents);
    }
    
    calendar.render();
    calendar.updateSize();
}

    
function create_tooltip(data)
{
    var teacher = data.teacher;
    var client = data.client;
    if(data.combinedstudents!=null)
        client= '['+data.combinedstudents+']';
    
    if(teacher==null|| teacher=="null")teacher="unassigned";
    
    var tooltip = "<div class='w3-card w3-sand w3-border' style='text-align:left;margin:0;padding:0;width:100%'>";
    
    tooltip +="<ul class='w3-ul w3-light-grey w3-border'>";

    var style="text-align:center;color:" + data.textColor + ";background:"+ data.backgroundColor+";";
    
    tooltip+='</ul>';
    
    tooltip +="<table class='w3-table w3-table-all w3-small'>";
    tooltip +="<tr><td colspan='2' style='" + style + "'>" +data.status_display+ "(id="+data.id+")</td></tr>";
    tooltip +="<tr><td style='text-align:center'>"+data.duration+" min.</td><td style='text-align:center'>" + data.tooltip_title +"</td></tr>";
    tooltip +="<tr><td><i class='fas fa-chalkboard-teacher'></i></td><td>"+teacher+"</td></tr>";
    tooltip +="<tr><td><i class='fas fa-user-graduate'></i></td><td>"+client+"</td></tr>";
    tooltip +="<tr><td><i class='fa fa-hourglass-start' aria-hidden='true'></i></td><td>"+moment(data.start).format("lll")+ "</td></tr>";
    tooltip +="<tr><td><i class='fa fa-hourglass-end' aria-hidden='true'></i></td><td>"+moment(data.end).format("lll")+ "</td></tr>";
    tooltip += '</table></div>';
    
    return tooltip;
}

function init_calendar(calendar_id, width, height)
{
    
    var calendarEl = document.getElementById(calendar_id);
    var calendar = new FullCalendar.Calendar(calendarEl,{
      plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
    timezone: 'local',
    editable: false,
    defaultView: 'dayGridMonth',
        
        "dayClick": function(date, jsEvent, view)
        {
            if(document.getElementById('start')!=null)
            {
                $('#start').val(date.format('MM/DD/YYYY hh:mm A'));
            }
            if(document.getElementById('datetimepicker1')!=null)
            {
                $('#datetimepicker1').data("DateTimePicker").date(date);
            }
            $(".fc-state-highlight").removeClass("fc-state-highlight");
            $(jsEvent.target).addClass("fc-state-highlight");
        },

        "eventClick":function(event)
        {
            if (event.url) {window.open(event.url);return false;}
        },
        eventRender: function(info) {
            $(info.el).tooltip({title: info.event.extendedProps.description,
                  container: 'body',
                  html:true,
                  placement:"left",
                  template:'<div class="tooltip"  role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner" style="margin:0;padding:0;"></div></div>',
                  delay: { "show": 500, "hide": 300 }
        });
      },

    });
    
    return calendar;
}

function clear_calendars(cal1, cal2)
{
    cal1.removeAllEventSources();
    
    cal2.removeAllEventSources();
}
function render_calendars(cal1, cal2)
{
    cal1.render();
    cal1.updateSize();
    cal2.render();
    cal2.updateSize();
}

function init_calendar_events(cal, nevents)
{
    cal_addEventSource(cal, nevents);
    cal.updateSize();
    cal.render();
}

function init_coming_calendar(nevents)
{
    init_calendar_events(g_coming_classes, nevents);
}

function init_past_calendar(nevents)
{
    init_calendar_events(g_pastclasses, nevents);
}

function load_teacher_client_events(teacher_id, client_id)
{
    load_teacher_client_courses_calendar(g_coming_classes, teacher_id, client_id, 1);
    load_teacher_client_courses_calendar(g_pastclasses, teacher_id, client_id, 0);
    
    g_coming_classes.updateSize();
    g_coming_classes.render();
    g_pastclasses.updateSize();
    g_pastclasses.render();
}

function load_teacher_client_courses_calendar(calendar, teacher_id, client_id, coming)
{
    calendar.removeAllEventSources();
    $.get( "{{ env('APP_URL') }}"+"/ajax_teacher_client_classes?client_id=" + client_id+"&teacher_id=" + teacher_id + '&coming='+coming+"&status_id=-1", function(nevents)
    {
        cal_addEventSource(calendar, nevents);
    });
}

function load_teacher_client_trials_calendar(calendar, teacher_id, client_id, coming)
{
    calendar.removeAllEventSources();

    $.get( "{{ env('APP_URL') }}"+"/ajax_teacher_client_trials?client_id=" + client_id+"&teacher_id=" + teacher_id + '&coming='+coming+"&status_id=-1", function(nevents)
    {
        cal_addEventSource(calendar, nevents);
    });
}



function cal_addEvents_rawSource(calendar, nevents)
{
    var url="{{route('events.show', -999)}}";
    
    if(nevents.length>0)
    {
        for(var i=0;i<nevents.length; i++)
        {
            nevents[i].client=nevents[i].client.name;
            nevents[i].status_display=nevents[i].status.display;
            
            if(nevents[i].teacher)
                nevents[i].teacher=nevents[i].teacher.name;
                    
            nevents[i].org_utc_start=nevents[i].start;
            
            var utc_start=moment.tz(nevents[i].org_utc_start, 'UTC');
            
            var utc_end = utc_start;
            utc_end=utc_end.add(nevents[i].duration, 'minutes');
            nevents[i].org_utc_end=utc_end;
            
            var client = nevents[i].client;
            
            if(client==null|| client=="null")client="unassigned";
            nevents[i].tooltip_title    =   nevents[i].title;
            nevents[i].title    =   client;//.format("YYYY-MM-DD h:mm A");
            
            nevents[i].utc_start    =   utc_start;//.format("YYYY-MM-DD h:mm A");
            nevents[i].utc_end      =   utc_end;//.format("YYYY-MM-DD h:mm A");
            
            var tzstart = moment.tz(nevents[i].org_utc_start, 'UTC');
            tzstart.tz( moment.tz.guess());
            nevents[i].start = tzstart.format();//"YYYY-MM-DD h:mm A");
            
            var tzend = moment.tz(utc_end.format(), 'UTC');
            tzend.tz( moment.tz.guess());
            nevents[i].end = tzend.format();//"YYYY-MM-DD h:mm A");
            nevents[i].description = create_tooltip(nevents[i]);
            var res = url.replace("-999", nevents[i].id);
            nevents[i].url = res;
        }
        calendar.addEventSource(nevents);
    }
    calendar.render();
    calendar.updateSize();
}

jQuery(document).ready(function ()
{
    g_pastclasses = init_calendar('past_classes_calendar', 800, 800);
    g_coming_classes = init_calendar('comming_classes_calendar', 800, 800);

    g_pastclasses.today();
    g_coming_classes.today();
    


    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e)
    {
        if(e.target.id=='coming')
        {
            g_coming_classes.render();
            g_coming_classes.updateSize();
        }

        else if(e.target.id=='past')
        {
            g_pastclasses.render();
            g_pastclasses.updateSize();
        }

        if (g_triggered==false)
        {
            g_triggered=true;
            $(".fc-today-button").trigger('click');
        }
    });
    
});
</script>
