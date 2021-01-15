<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-alpha.16
* @link https://tabler.io
* Copyright 2018-2020 The Tabler Authors
* Copyright 2018-2020 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="fr">
    @include('0 tabler.layout.head')

    <body class="antialiased">
        <div class="page">
            @livewire('tabler.layout.navbar')
            <div class="content">
                <div class="container-xl">
                    @include('0 tabler.layout.breadcrumb')
                    @yield('content')
                </div>
                @include('0 tabler.layout.footer')
            </div>
        </div>
        @include('0 tabler.layout.script')
        @yield('script')
        @livewireScripts
    </body>
</html>
