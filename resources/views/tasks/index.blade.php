@extends('layouts.app')
@section('content')
<div class="x_panel">
    <div class="x_title">
        Tasks
<a href="{{ url()->previous() }}" class="nav-item nav-link  float-right">Back</a><div class='clearfix'></div>
    </div>
    <div class="x_title">Page {{ $tasks->currentPage() }} of {{ $tasks->lastPage() }}</div>
    <div class="x_content">
        <div class="row">
            @foreach ($tasks as $task)
            @if( Auth::check() )
                <div class="x_content">
                    <li style="list-style-type:disc">
                        <a href="{{ route('tasks.show', $task->id ) }}"><b>{{ $task->name}}</b></a>
                    </li>
                </div>
            @endif
            @endforeach
        </div>
        <div class="row text-center">
            {!! $tasks->links() !!}
        </div>
    </div>
</div>
        


@endsection
