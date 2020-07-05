@extends('layouts.app')
@section('content')
<div class="x_panel">
<div class="x_title" >Users <a href="{{ url()->previous() }}" class="btn btn-primary float-right">Back</a></div>
<div class="x_title" >Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</div>
<div class="x_content" >
    <div class="row">
        @foreach ($users as $user)
        @if( Auth::check() )
            <div class="x_content">
                <li style="list-style-type:disc">
                    <a href="{{ route('users.show', $user->id ) }}"><b>{{ $user->name}}</b></a>
                </li>
            </div>
        @endif
        @endforeach
    </div>
    <div class="row text-center">
        {!! $users->links() !!}
    </div>
</div>
        
</div>
@endsection
