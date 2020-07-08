@guest
<div id="content" >
@yield('content')
</div>
@endguest

@auth
<div id="content" style="margin-left:15%">
    @include('layouts.includes.message')
    @include('layouts.includes.error')
    @yield('content')
</div>
@endauth