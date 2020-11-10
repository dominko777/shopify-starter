@extends('shopify-app::layouts.default')

@section('content')
      <!-- @include('partials.activate-modal') -->

@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        var AppBridge = window['app-bridge'];
        var actions = AppBridge.actions;
        var TitleBar = actions.TitleBar;
        var Button = actions.Button;
        var Redirect = actions.Redirect;
        var titleBarOptions = {
            title: 'Dashboard',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);

        function setupTheme() {
            alert('1111');
        }   
    </script>
@endsection