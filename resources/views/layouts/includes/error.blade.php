@if ($errors->any())
                <div class="container">
                <div class="panel panel-default">
                <div class="panel-heading">
                <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
                </div>
                </div>
                </div>
                </div>
            @endif