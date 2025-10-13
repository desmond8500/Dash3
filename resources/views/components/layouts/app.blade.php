<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <meta name="description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!" />

    {{-- @trixassets --}}

    @assets
        <!-- CSS files -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.2.0/dist/css/tabler.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-flags.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-payments.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-vendors.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.30.0/tabler-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"  />
        <link rel="stylesheet" href="{{ asset('css/tabler.css') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])


        @stack('css')
        <style>
            @import url('https://rsms.me/inter/inter.css');

            :root { --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; }

            body {
                font-feature-settings: "cv03", "cv04", "cv11";
            }
            .ti{
                margin-right: 2px;
            }
        </style>
    @endassets
</head>

<body>
    <div class="page">
        @livewire('layout.navbar')

        <div class="page-wrapper">
            @php
                if (auth()->user()) {
                    $settings = \App\Models\Setting::where('user_id', auth()->user()->id)->first();
                }
            @endphp

            @auth
                <div class="{{ $settings->size ?? "container-xl"}}">
            @else
                <div class="container-xl">
            @endauth

                {{ $slot }}
            </div>
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row">
                        <div class="col">
                            Version 1.0.0
                        </div>
                        <div class="col-auto mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; 2025
                                    <a href="." class="link-secondary">Tabler</a>.
                                    All rights reserved.
                                </li>
                                <li class="list-inline-item" wire:ignore.seft>
                                    <a href="#" wire:click.prevent="$emit('scrollTop')" class="btn btn-primary btn-icon" >
                                        <i class="ti ti-arrow-up"></i>
                                    </a>
                                </li>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                    Livewire.on('scrollTop', () => {
                                      window.scrollTo({ top: 0, behavior: 'smooth' });
                                    });
                                  });
                                </script>
                            </ul>
                        </div>
                    </div>

                </div>
            </footer>

        </div>
    </div>

        {{-- Jquery --}}
        {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}

        <script wire:navigated src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <!-- Tabler Core -->
        <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.2.0/dist/js/tabler.min.js"></script>
        {{-- Select2 --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
        {{-- Autosize --}}
        <script src="https://cdn.jsdelivr.net/npm/autosize@5.0.1/dist/autosize.min.js"></script>
        {{-- Masonry --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js" defer></script> --}}
        {{-- Sweetalert --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

        <script>
            autosize(document.querySelectorAll('textarea'));
        </script>


</body>

</html>
