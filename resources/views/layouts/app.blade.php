<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
     <link href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" rel="stylesheet" />
     <!-- Favicon -->
     <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

     <!-- Fonts -->
     <link rel="preconnect" href="{{ url('https://fonts.googleapis.com') }}" />
     <link rel="preconnect" href="{{ url('https://fonts.gstatic.com') }}" crossorigin />
     <link
         href="{{ url('https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap') }}"
         rel="stylesheet" />
     <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">

     <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
     <script src="{{ asset('assets/js/config.js') }}"></script>
     <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
     <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
     <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
     <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
     <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
     <script src="{{ asset('assets/js/main.js') }}"></script>
     <script async defer src="{{ url('https://buttons.github.io/buttons.js') }}"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('admin.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('includes.header')
                <!-- /Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('layout-wrapper')
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('includes.footer')
                    <!-- / Footer -->

                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>
    <!-- / Layout wrapper -->

</body>

</html>