<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.1.1
* @link https://tabler.io
* Copyright 2018-2025 The Tabler Authors
* Copyright 2018-2025 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>{{ env('APP_NAME', 'Dash3') }}</title>
        {{-- <script defer data-api="/stats/api/event" data-domain="preview.tabler.io" src="/stats/js/script.js"></script> --}}
        <meta name="msapplication-TileColor" content="#0054a6" />
        <meta name="theme-color" content="#0054a6" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ asset('fav.ico') }}" type="image/x-icon" />
        <meta name="description"
            content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!" />
        <meta name="canonical" content="https://tabler.io/demo/layout-condensed.html">
        <meta name="twitter:image:src" content="https://tabler.io/demo/static/og.png">
        <meta name="twitter:site" content="@tabler_ui">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title"
            content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
        <meta name="twitter:description"
            content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
        <meta property="og:image" content="https://tabler.io/demo/static/og.png">
        <meta property="og:image:width" content="1280">
        <meta property="og:image:height" content="640">
        <meta property="og:site_name" content="Tabler">
        <meta property="og:type" content="object">
        <meta property="og:title"
            content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
        <meta property="og:url" content="https://tabler.io/demo/static/og.png">
        <meta property="og:description"
            content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
        <!-- CSS files -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-flags.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-payments.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-vendors.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.30.0/tabler-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="{{ asset('css/tabler.css') }}">
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <!-- END CUSTOM FONT -->
</head>

<body>
    <!-- BEGIN DEMO THEME SCRIPT -->
    <script src="./preview/js/demo-theme.min.js?1740838744"></script>
    <!-- END DEMO THEME SCRIPT -->
    <div class="page page-center">
        {{ $slot }}
    </div>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="./dist/js/tabler.min.js?1740838744" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN DEMO SCRIPTS -->
    <script src="./preview/js/demo.min.js?1740838744" defer></script>
    <!-- END DEMO SCRIPTS -->
    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"91fd52cb7f50ec8f","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"version":"2025.1.0","token":"84cae67e72b342399609db8f32d1c3ff"}'
        crossorigin="anonymous"></script>
</body>

</html>
