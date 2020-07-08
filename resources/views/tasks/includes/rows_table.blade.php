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
                    <th>Operations</th>
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
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-edit pull-left" style="margin-right: 3px;">Edit</a>
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
