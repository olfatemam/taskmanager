@extends('layouts.app')
@section('content')
<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>Statuses</h3>
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a>
<a href="{{ route('statuses.create') }}" class="btn btn-primary float-right" style='margin-right: 10px'>Add Status</a>
<div class='clearfix'></div>
<div class="panel-body" >
    
    <div class="row">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Name</th>
                    <th>Reminder</th>
                    
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statuses as $status)
                <tr>
                    <td>{{ $status->name }}</td>
                    <td>{{ ($status->reminder)?"YES":"NO" }}</td>
                    <td>
                    <a href="{{ route('statuses.edit', $status) }}" class="btn btn-edit pull-left" style="margin-right: 3px;">Edit</a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['statuses.destroy', $status] ]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
</div>
</div>
</div>
</div>

@endsection