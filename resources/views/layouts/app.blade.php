<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chatty') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body,
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Helvetica Neue, Segoe UI, Helvetica, Arial, sans-serif;
        ;
        }

        ::-webkit-scrollbar {
            width: 7px;
            transition: all 0.3s;
        }

        ::-webkit-scrollbar-track {
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #95a5a6;
        }

        .thumb {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .content-wrapper {
            /*position: absolute;*/
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        @media only screen and (max-width: 767px) {
            .aside {
                position: absolute;
                height: 100%;
                width: 100%;
                left: -100%;
                background: #fff;
                z-index: 2;
                -webkit-box-shadow: 5px 0px 5px 0px rgba(119,119,119,0.1);
                -moz-box-shadow: 5px 0px 5px 0px rgba(119,119,119,0.1);
                box-shadow: 5px 0px 5px 0px rgba(119,119,119,0.1);
                transition: all 0.3s;
            }
            .aside.open {
                left: 0;
            }
            .mobile-overlay {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0; right: 0; bottom: 0; left: 0;
                z-index: 1;
                background: rgba(0, 0, 0, .1);
                display: none;
            }
            .mobile-overlay.open {
                display: block;
            }
        }

        .aside {
            height: 100%;
            overflow-y: auto;
        }
        .aside nav h2 {
            /* width: 70px; */
            font-size: 1.5em;
            font-weight: 700;
        }

        .aside nav {
            padding: 1em 0;
            margin: 0;
        }

        .aside nav .thumb {
            margin-right: 0.5em;
        }

        .users-list ul {
            list-style: none;
        }

        .users-list .user {
            cursor: pointer;
            display: block;
            width: 100%;
            height: 100%;
            text-decoration: none;
            background: #ffffff;
            margin:  0.5em 0;
            padding: 0.2em 0;
            padding-left: 0.2em;
            border-radius: 10px;
        }

        .users-list .user .name {
            color: #000000;
            font-size: 15px;
        }

        .users-list .user .message {
            color: #777777;
            font-size: 13px;
        }

        .users-list .user .new-msg-label {
            position: absolute;
            z-index: 5;
            color: #fff;
            background: yellowgreen;
            width: 18px;
            height: 18px;
            /*display: flex;*/
            justify-content: center;
            flex-direction: column;
            margin: 0 auto;
            padding: 0 5px;
            border-radius: 50%;
            left: 10px;
            font-size: 12px;
            display: none;
        }

        .users-list .user.notify .new-msg-label {
            display: block;
        }
        .users-list .user.notify .last-message {
            font-weight: bold;
            color: #1b1e21;
        }

        .users-list .user:hover {
            background: #f7f7f7;
        }

        .users-list .user.active {
            background: #0084ff;
        }

        .users-list .user.active .name {
            color: #ffffff;
        }

        .users-list .user.active .message {
            color: #f2f2f2;
        }
        main {
            background: #fff;
        }

        .main {
            height: 100%;
            border-left: 1px solid rgba(0, 0, 0, .10);

        }

        .main .chat-screen ul {
            list-style: none;
        }

        .main nav h2 {
            font-size: 15px;
            font-weight: bold;
        }

        .main nav {
            /* height: 60px; */
            padding: 0.5em 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: 0 1.85em;
        }

        .main nav .thumb {
            margin-right: 0.5em;
        }

        /* ************************************** */
        .incoming-msg-img {
            display: inline-block;
            width: 6%;
        }

        @media only screen and (min-width: 768px) {
            .incoming-msg-img {
                width: 4%;
            }
        }
        @media only screen and (min-width: 992px) {
            .incoming-msg-img {
                width: 2%;
            }
        }

        .incoming-msg-img img {
            width: 28px;
            height: 28px;
        }
        .received-msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            max-width: 75%;
        }
        .received-withd-msg p {
            background: #f1f0f0 none repeat scroll 0 0;
            -webkit-border-radius: 25px;
            -webkit-border-top-left-radius: 0;
            -moz-border-radius: 25px;
            -moz-border-radius-topleft: 0;
            border-radius: 25px;
            border-top-left-radius: 0;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 20px;
            width: 100%;
        }
        .time-date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }
        .received-withd-msg { width: 100%;}
        .mesgs {
            float: left;
            /* padding: 0px 0px 0px 25px; */
            height: calc(100% - 66px);
            border-top: 1px solid rgba(0, 0, 0, .10);
            width: 100%;
        }

        .sent-msg p {
            background: #0084ff none repeat scroll 0 0;
            -webkit-border-radius: 25px;
            -webkit-border-top-right-radius: 0;
            -moz-border-radius: 25px;
            -moz-border-radius-topright: 0;
            border-radius: 25px;
            border-top-right-radius: 0;
            font-size: 14px;
            margin: 0;
            color:#fff;
            padding: 5px 10px 5px 12px;
            width:100%;
        }
        .outgoing-msg{ overflow:hidden; margin:26px 0 26px;}
        .sent-msg {
            float: right;
            max-width: 75%;
        }

        .type-msg {
            height: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;

        }

        .btn-send {
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0084ff;
            color: #fff;
            padding: 0;
        }

        .type-msg input {
            border-radius: 25px;
            -webkit-box-shadow: inset 0px 0px 5px 0px rgba(238,238,238,1);
            -moz-box-shadow: inset 0px 0px 5px 0px rgba(238,238,238,1);
            box-shadow: inset 0px 0px 5px 0px rgba(238,238,238,1);
        }

        .type-msg input:focus {
            border-color: #ced4da;
            -webkit-box-shadow: inset 0px 0px 5px 0px rgba(238,238,238,1);
            -moz-box-shadow: inset 0px 0px 5px 0px rgba(238,238,238,1);
            box-shadow: inset 0px 0px 5px 0px rgba(238,238,238,1);
        }

        .msg-history {
            height: calc(100% - 50px);
            padding: 1em 0;
            overflow-y: auto;
            padding-right: 0.3em;
            border-bottom: 1px solid rgba(0, 0, 0, .1);
            padding-left: 25px;

        }
        @media only screen and (min-width: 768px) {
            .msg-history {
                padding-right: 1em;
            }
        }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand navbar-light bg-white shadow-sm ">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Chatty
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

</body>
</html>
