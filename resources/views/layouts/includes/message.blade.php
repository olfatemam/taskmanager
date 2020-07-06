@if(Session::has('flash_message'))
    
            <div class="container">
            <div class="panel panel-default">
            <div class="panel-heading">
            <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
            </div>
            </div>
            </div>
            </div>
            @endif