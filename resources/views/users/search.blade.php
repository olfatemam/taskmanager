@extends('layouts.app')
@section('title', '| Manage Users')
@section('content')

<div class="container">
<div class="panel panel-default">
<div class="panel-heading"><h3>Users</h3>
<a href="{{ url()->previous() }}" class="btn btn-primary float-right" >Back</a>
<div class='clearfix'>
</div>
<div class="panel-body" >
<div class="row text-center">Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
</div>

<div class="row">

    <div class="table-responsive">
        <table id="resultstable" class="table table-bordered table-striped">
        <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit btn-success" style="margin-right: 3px;">Edit</a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

<div class="row text-center">
    {!! $users->appends(Request::all())->links() !!}
</div>
    
</div>
</div>
</div>
</div>

@endsection



@section('content_styles')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.6/css/rowReorder.dataTables.min.css"/>

@endsection


@section('content_scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.6/js/dataTables.rowReorder.min.js"></script>

<script type="text/javascript">
    
jQuery(document).ready(function()
{
    var table = $('#resultstable').DataTable( {
        rowReorder: false,
        paging: false
    } );


 } );
</script>
@endsection

