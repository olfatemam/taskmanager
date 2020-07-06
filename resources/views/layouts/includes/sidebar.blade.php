<!-- Sidebar -->
@auth
<link href="{{ asset('libs/w3.css') }}" rel='stylesheet' />

<div class="w3-sidebar w3-light-grey w3-bar-block" style="width:10%">
  
  <a href="{{route('tasks.calendar')}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-check">Calendar</i></a>
  <a href="{{route('tasks.list_filtered', \App\Task::Active)}}" class="w3-bar-item w3-button"><i class="fas fa-tasks">Active</i></a>
  <a href="{{route('tasks.list_filtered', \App\Task::Today)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-day"> Today</i></a>
  <a href="{{route('tasks.list_filtered', \App\Task::Coming)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-plus"> Coming</i></a>
  <a href="{{route('tasks.list_filtered', \App\Task::Overdue)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-times"> Overdue</i></a>
  
  <a href="{{route('tasks.list_filtered', \App\Task::Finished)}}" class="w3-bar-item w3-button"><i class="fas fa-calendar-check"> Finished</i></a>
  <a href="{{route('tasks.tags')}}" class="w3-bar-item w3-button"><i class="fa fa-tags" aria-hidden="true">Tags</i> </a>
  
  <hr>
  <a href="{{ route('tasks.search') }}" class="w3-bar-item w3-button"><i class="fa fa-tasks" aria-hidden="true"> Control</i></a>
  
</div>

@endauth