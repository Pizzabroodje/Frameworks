@extends('layouts.app')

@section('nav')
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">999GAMES</a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu<i class="fas fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <!-- Right side of nav -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication links -->
                    @if(Auth::check())
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('tournaments.index') }}">Tournamenten</a></li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            {{ __('Uitloggen') }}
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('login') }}">Inloggen</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('register') }}">Registreren</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@overwrite


@section('content')
<!-- Masthead-->
<header class="masthead">
    <div class="container d-flex h-100 align-items-center">
        <div class="mx-auto text-center">
            <h1 class="mx-auto my-0 text-uppercase">999GAMES</h1>
            <h2 class="text-white-50 mx-auto mt-2 mb-5">Meld je hier aan voor tournamenten en bekijk de tafelindeling</h2>
            <a class="btn btn-primary js-scroll-trigger" href="{{route('tournaments.index')}}">Begin nu!</a>
        </div>
    </div>
</header>

<!-- Footer-->
<footer class="footer bg-black small text-center text-white-50"><div class="container">Copyright © Daniel den Toom 2020</div></footer>


<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Core theme JS-->
<script src="{{asset('js/scripts.js')}}"></script>
@endsection
