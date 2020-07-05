@if(Auth::user()->is_admin())

<li class="nav-item">
    <a class="nav-link" href="{{ route('users') }}">{{ __('Users') }}</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('tasks.search') }}">{{ __('Tasks') }}</a>
</li>
 
@else

<li class="nav-item">
    <a class="nav-link" href="{{ route('tasks.create') }}">{{ __('Add Task') }}</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('tasks.search') }}">{{ __('Tasks') }}</a>
</li>

@endif