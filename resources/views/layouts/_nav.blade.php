
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name')}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarMenu">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto" style="padding-left:10px">
                <li class="nav-item"><a class="nav-link" href="/home">Bienvenue(e)</a></li>
                <li class="nav-item"><a class="nav-link" href="/predictions">Pronostics</a></li>
                <li class="nav-item"><a class="nav-link" href="/phase">Matches</a></li>
                <li class="nav-item"><a class="nav-link" href="/ranking">Classement</a></li>
                <li class="nav-item"><a class="nav-link" href="/slides">Slides</a></li>
                @auth
                @if( Auth::user()->isAdmin())
                <li {{ (isset($page) && $page == 'admin') ? 'class=active' : ''}}><a class="nav-link" href="/games">Admin</a></li>
                @endif
                @endauth
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto pull-right">
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @else
                    <li class="nav-link">
                        {{ Auth::user()->name }}
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
