<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ $config[0]->value ?? 'Dash 1.0' }}</title>
    <!-- CSS files -->
    <link href="{{ asset('template/tabler/dist/css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('template/tabler/dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('template/tabler/dist/css/tabler-payments.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('template/tabler/dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('template/tabler/dist/css/demo.min.css') }}" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('template/adminlte3/plugins/select2/css/select2.min.css') }}">

    @yield('link')
    <style>
      body { display: none; }
    </style>
    @livewireStyles
</head>
