<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Include pickadate plugin -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pickadate@3.6.3/lib/themes/default.css">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('frontend/frontend.invoice_system') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome/all.min.css') }}">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @if (config('app.locale') == 'ar')
        <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-rtl.css') }}">
    @endif
    @yield('style')
</head>

<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                @include('partial.flash')
                @yield('content')
            </div>
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('frontend/js/fontawesome/all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pickadate@3.6.3/lib/picker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pickadate@3.6.3/lib/picker.date.js"></script>
<script>
    $(function() {
        $('#session-alert').fadeTo(2000,500).slideUP(500 , function (){
            $('#session-alert').slideUp(500)
        })
    })
</script>
    @yield('script')
</body>

</html>
