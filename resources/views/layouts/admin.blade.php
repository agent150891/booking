<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Світязь. Адмінка</title>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/admin.css')}}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/verify2.js')}}"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="https://use.fontawesome.com/5ec193cf54.js"></script>
    <script src="{{ url('/js/verify2.js')}}"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Головна
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                                @if (url()->current()==url('/admin/statistic'))
                                    <li class="active">
                                @else
                                    <li>
                                @endif
                                    <a href="{{ url('/admin/statistic')}}">Статистика</a></li>

                                @if (url()->current()==url('/admin/hotels'))
                                    <li class="active"><a href="{{ url('/admin/hotels')}}">Оголошення</a></li>
                                @else
                                    <li><a href="{{ url('/admin/hotels')}}">Оголошення</a></li>
                                @endif

                                @if (url()->current()==url('/admin/pays'))
                                    <li class="active">
                                @else
                                    <li>
                                @endif
                                    <a href="{{url('/admin/pays')}}">Платежі</a></li>


                                <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Налаштування
                                    <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                      <li><a href="{{url('/admin/paidservices')}}">Налаштування вартості</a></li>
                                      <li><a href="{{url('/admin/features')}}">Категорії</a></li>
                                      <li><a href="{{url('/admin/sms')}}">Налаштування СМС</a></li>
                                      <li><a href="{{url('/admin/cities')}}">Перелік міст</a></li>
                                      <li><a href="{{url('/admin/other')}}">Інші налаштування</a></li>
                                      <li><a href="{{url('/admin/users')}}">Користувачі</a></li>
                                      <li><a href="{{url('/admin/feeds')}}">Відгуки</a></li>
                                    </ul>
                                </li>
                    </ul>

                </div>
            </div>
        </nav>
        <div id="alert-block">

        </div>
        @yield('content')
    </div>

    <!-- Scripts -->

</body>
</html>
