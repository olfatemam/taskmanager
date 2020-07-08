<div class="w3-row">
<table class="w3-table w3-table-all" >
    @foreach ( $tasks as $task )
    <tr>
        <td>
            @if($task->completed==false)
                <a title="finish" class="btn-edit btn-primary {{$task->priority->name}}" href="{{route('tasks.complete', $task->id) }}"><i class="fa fa-check" aria-hidden="true"></i></a>
            @endif
            <a title="edit" class="btn-edit btn-primary w3-inverted" href="{{route('tasks.edit', $task->id) }}"><i class="fa fa-edit" aria-hidden="true"></i></a>
        </td>
        <td>{{ $task->hagar_due() . ' ' }}</td>
        <td><a href="{{route('tasks.show', $task->id) }}">{{$task->name }}</a></td>
        <td>{!!$task->tags()!!}</td>
        <td>{!!$task->state()!!}</td>
        </tr>
    </tr>
  
  @endforeach
</table>
</div>

<div class="w3-row w3-center">
    {!! $tasks->appends(Request::all())->render() !!}
</div>
