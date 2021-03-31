<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <title>Privacy policy</title>
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
        @yield('styles')
    </head>
  

    <body cz-shortcut-listen="true">
        <div class="container-fluid main" id="app">
            <div class="column">
                @yield('content')
            </div>
        </div>
    </body>
</html>