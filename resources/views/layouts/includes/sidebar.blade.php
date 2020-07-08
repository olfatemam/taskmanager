<!-- Sidebar -->
@auth
<link href="{{ asset('libs/w3.css') }}" rel='stylesheet' />

<div class="w3-sidebar w3-light-grey w3-bar-block" style="width:10%">
  
  <a href="{{route('tasks.calendar')}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-check">Calendar</i></a>
  <a href="{{route('tasks.search', \App\Enum\TaskFilter::Active)}}" class="w3-bar-item w3-button"><i class="fas fa-tasks">Active</i></a>
  <a href="{{route('tasks.search', \App\Enum\TaskFilter::Today)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-day"> Today</i></a>
  <a href="{{route('tasks.search', \App\Enum\TaskFilter::Coming)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-plus"> Coming</i></a>
  <a href="{{route('tasks.search', \App\Enum\TaskFilter::Overdue)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-times"> Overdue</i></a>
  
  <a href="{{route('tasks.search', \App\Enum\TaskFilter::Finished )}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-check"> Finished</i></a>
  <a href="{{route ( 'tasks.search', \App\Enum\TaskFilter::Tags ) }}" class="w3-bar-item w3-button"><i class="fa fa-tags" aria-hidden="true">Tags</i> </a>
  
  <a href="{{ route('tasks.search', \App\Enum\TaskFilter::Search) }}" class="w3-bar-item w3-button"><i class="fa fa-tasks" aria-hidden="true"> Control</i></a>
  
</div>

@endauth