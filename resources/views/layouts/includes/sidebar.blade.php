<!-- Sidebar -->
@auth
<link href="{{ asset('libs/w3.css') }}" rel='stylesheet' />

<script>

function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-green";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-green", "");
  }
}

</script>


<div class="w3-sidebar w3-light-grey w3-card" style="width:10%">

<a href="{{route('tasks.calendar')}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-check">Calendar</i></a>
<a href="{{route('tasks.search', \App\Enum\TaskFilter::Active)}}" class="w3-bar-item w3-button"><i class="fas fa-tasks">Active</i></a>
<a href="{{route('tasks.search', \App\Enum\TaskFilter::Today)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-day"> Today</i></a>
<a href="{{route('tasks.search', \App\Enum\TaskFilter::Coming)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-plus"> Coming</i></a>
<a href="{{route('tasks.search', \App\Enum\TaskFilter::Overdue)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-times"> Overdue</i></a>
<a href="{{route('tasks.search', \App\Enum\TaskFilter::Finished )}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-check"> Finished</i></a>
<a href="{{route ( 'tasks.search', \App\Enum\TaskFilter::Tags ) }}" class="w3-bar-item w3-button"><i class="fa fa-tags" aria-hidden="true">Search Tags</i> </a>
<a href="{{ route('tasks.search', \App\Enum\TaskFilter::Search) }}" class="w3-bar-item w3-button"><i class="fa fa-tasks" aria-hidden="true"> Control</i></a>

<button class="w3-button w3-block w3-left-align" onclick="myAccFunc()">
    Keys <i class="fa fa-caret-down"></i>
</button>
<div id="demoAcc" class="w3-hide w3-white w3-card">
@foreach(\App\Task::get_tags_and_frequencies() as $key)
    <a href="{{route ( 'tasks.tags', $key[0]) }}" class="w3-bar-item w3-button pull-left" style='width: 100%'>{{$key[0].'('.$key[1].')'}}</a>
@endforeach
</div>
  
  
</div>
@endauth