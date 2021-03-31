<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <title>{{ config('shopify-app.app_name') }}</title>
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
        @yield('styles')
    </head>
  

    <body cz-shortcut-listen="true">
        <div class="container-fluid main" id="app">
            <div class="columns">
                <div class="column is-2">
                    @include('partials.menu_left') 
                </div>
                <div class="column is-10">
                    <router-view></router-view>
                </div>
            </div>
        </div>

        @if(config('shopify-app.appbridge_enabled'))
            <script src="https://unpkg.com/@shopify/app-bridge{{ config('shopify-app.appbridge_version') ? '@'.config('shopify-app.appbridge_version') : '' }}"></script>
            <script>
                var AppBridge = window['app-bridge'];
                var createApp = AppBridge.default;
                var app = createApp({
                    apiKey: '{{ config('shopify-app.api_key') }}',
                    shopOrigin: '{{ Auth::user()->name }}',
                    forceRedirect: true,
                });
            </script>

            @include('shopify-app::partials.flash_messages')
        @endif

        @yield('scripts')
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>