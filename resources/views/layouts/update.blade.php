<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

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

            .person-name-card{
                color: #fff;
            }

            .v-card-text-span-label{
                color: red;
            }
            
          @-moz-keyframes loader {
            from {
              transform: rotate(0);
            }
            to {
              transform: rotate(360deg);
            }
          }
          @-webkit-keyframes loader {
            from {
              transform: rotate(0);
            }
            to {
              transform: rotate(360deg);
            }
          }
          @-o-keyframes loader {
            from {
              transform: rotate(0);
            }
            to {
              transform: rotate(360deg);
            }
          }
          @keyframes loader {
            from {
              transform: rotate(0);
            }
            to {
              transform: rotate(360deg);
            }
          }
        </style>
    </head>
    <body>
        <div id="app">
            <header-bar-nav-create>
              <register-form user="{{ $person }}" ></register-form>
            </header-bar-nav-create>

            @yield('content')
        </div>

    <script  src="{{ mix('js/app.js') }}"></script>
    </body>
    
</html>
