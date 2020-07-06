@guest
<div id="content" >
@yield('content')
</div>
@endguest

@auth
<div id="content" style="margin-left:10%">
    @include('layouts.includes.message')
    @include('layouts.includes.error')
    @yield('content')
</div>
@endauth