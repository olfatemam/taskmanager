@if(Auth::user()->is_admin())

<li class="nav-item">
    <a class="nav-link" href="{{ route('users') }}">{{ __('Users') }}</a>
</li>
@endif

<li class="nav-item">
    <a class="nav-link" href="{{ route('tasks.search') }}">{{ __('Manage Tasks') }}</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('tasks.list') }}">{{ __('List Tasks') }}</a>
</li>
 
