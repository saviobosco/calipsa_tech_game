<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} </title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', '') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li>
                        <a class="nav-link" href="#">{{ __('Help') }}</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        @if(Session::has('success'))
                            <div class="alert alert-success mt-2" role="alert">
                                <i class="fa fa-check-circle"></i>
                                <strong>Success:</strong>
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if(Session::has('warning'))
                            <div class="alert alert-soft-warning  align-items-center m-0 mt-2" role="alert">
                                <div class="text-body"><strong>warning</strong>
                                    {{ Session::get('warning') }}
                                </div>
                            </div>
                        @endif

                        @if(Session::has('info'))
                            <div class="alert alert-info mt-2" role="alert">
                                <div class="text-body"><strong>Info - </strong>
                                    {{ Session::get('info') }}
                                </div>
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger mt-2" role="alert">
                                <strong>Error - </strong>
                                {{ Session::get('error') }}
                            </div>
                        @endif
                </div>
            </div>
        </div>


        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/jquery/jquery.js') }}"></script>
@yield('footer-script');
</body>
</html>
