<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
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

          <v-app>
            <left-sidebar></left-sidebar>
            <template>
              <v-app-bar app light color="indigo darken-2">
                <snack-bar></snack-bar>
                <drawer-button></drawer-button>
                <v-spacer></v-spacer>
              </v-app-bar>
            </template>
            @yield('content')
            
          </v-app>
        </div>
    </body>
    <script  src="{{ mix('js/app.js') }}"></script>
    
</html>
