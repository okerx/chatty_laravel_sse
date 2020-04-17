<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Chatty') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <title>Chatty</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            /* General button style (reset) */
            .btn {
                text-decoration: none!important;
                border: none;
                font-family: inherit;
                font-size: inherit;
                color: inherit;
                background: none;
                cursor: pointer;
                padding: 25px 80px;
                display: inline-block;
                margin: 15px 30px;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-weight: 700;
                outline: none;
                position: relative;
                -webkit-transition: all 0.3s;
                -moz-transition: all 0.3s;
                transition: all 0.3s;
            }

            .btn:after {
                content: '';
                position: absolute;
                z-index: -1;
                -webkit-transition: all 0.3s;
                -moz-transition: all 0.3s;
                transition: all 0.3s;
            }
            .icon-arrow-right:before {
                content: "\276F";
            }
            /* Button 3 */
            .btn-3 {
                background: #0084ff;
                color: #fff;
            }

            .btn-3:hover {
                background: #0084ff;
            }

            .btn-3:active {
                background: #0084ff;
                top: 2px;
            }

            .btn-3:before {
                position: absolute;
                height: 100%;
                left: 0;
                top: 0;
                line-height: 3;
                font-size: 140%;
                width: 60px;
            }

            /* Button 3e */
            .btn-3e {
                padding: 25px 120px 25px 60px;
                overflow: hidden;
            }

            .btn-3e:before {
                left: auto;
                right: 10px;
                z-index: 2;
            }

            .btn-3e:after {
                width: 30%;
                height: 200%;
                background: rgba(255,255,255,0.1);
                z-index: 1;
                right: 0;
                top: 0;
                margin: -5px 0 0 -5px;
                -webkit-transform-origin: 0 0;
                -webkit-transform: rotate(-20deg);
                -moz-transform-origin: 0 0;
                -moz-transform: rotate(-20deg);
                -ms-transform-origin: 0 0;
                -ms-transform: rotate(-20deg);
                transform-origin: 0 0;
                transform: rotate(-20deg);
            }

            .btn-3e:hover:after {
                width: 40%;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Start A Chat</a>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="container">
                <div class="content">
                    <div class="title m-b-md" style="font-size: 75px">
                        Welcome To <span style="color: #0084ff; font-weight: bold">Chatty</span> Web App
                    </div>
                    <a href="/home" class="btn btn-3 btn-3e icon-arrow-right">Start Chatting</a>
                </div>
            </div>
        </div>
    </body>
</html>
