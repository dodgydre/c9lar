<nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}" style="padding-top: 0px; padding-left: -50px;">
                    <img src="{{URL::asset('images/logo.png')}}" height="50px" />
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="{{ set_active(['home', '/'], 'active') }}"><a href="{{ url('/home') }}">Home</a></li>
                    @if (!Auth::guest())
                        <li class="{{ set_active(['/procedures/*']) }}"><a href="{{ url('/procedures') }}">Procedures</a></li>
                        <li class="{{ set_active(['/insurers/*']) }}"><a href="{{ url('/insurers') }}">Insurers</a></li>
                        <li class="{{ set_active(['/patients/*']) }}"><a href="{{ url('/patients') }}">Patients</a></li>
                        <li class="{{ set_active(['/todo/*']) }}"><a href="{{ url('/tasks') }}">Todo</a></li>
                        @role('admin', 'owner')
                          <li class="{{ set_active(['/employee/*']) }}"><a href="{{ url('/employees') }}">Employees</a></li>
                        @endrole
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li class="{{ set_active([ 'login' ]) }}"><a href="{{ url('/login') }}">Login</a></li>
                        <li class="{{ set_active([ 'register' ]) }}"><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
