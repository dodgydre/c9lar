<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials._head')
    @yield('styles')
</head>
<body id="app-layout">

    @include('partials._nav')

    <div class="container-fluid">

      @include('partials._messages')

      @yield('content')

      @include('partials._footer')

    </div>

    @include('partials._javascript')

    @yield('scripts')
</body>
</html>
