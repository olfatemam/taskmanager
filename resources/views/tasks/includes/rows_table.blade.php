<div class="w3-row">
<div class="w3-table w3-table-all">
        <table class="w3-table w3-table-all">
        <thead>
                <tr>
                    <th>Name</th>
                    <th>Due</th>
                    <th>Priority</th>
                    <th>Completed</th>
                    <th>Reminder</th>
                    <th>Description</th>
                    <th colspan="2">Operations</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td><a href="{{route('tasks.show', $task->id) }}">{{$task->name}}</a></td>
                    
                    <td>{{ $task->hagar_due() }}</td>
                    <td>{{ $task->priority->name }}</td>
                    <td>{{ ($task->completed)?'YES':'NO' }}</td>
                    <td>{{ ($task->reminder)?'YES':'NO' }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-edit w3-blue"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    </td>
                    <td>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['tasks.destroy', $task] ]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
<div class="w3-row w3-center">
    {!! $tasks->appends(Request::all())->render() !!}
</div>
