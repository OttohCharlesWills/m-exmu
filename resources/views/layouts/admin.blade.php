<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <div id="admin-wrapper">
        @include('includes.adminsidebar')

        <main class="blogger-content py-4">
            @yield('admincontent')
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const blogToggle = document.getElementById('blogToggle');

            blogToggle.addEventListener('click', function () {
                this.closest('.has-sub').classList.toggle('open');
            });
        });
    </script>
</body>
</html>
