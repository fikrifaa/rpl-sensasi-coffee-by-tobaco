<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
        name="viewport">
    <title>@yield('title') &mdash; RESTO POS</title>

    <link rel="stylesheet"
        href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    @stack('style')

    <link rel="stylesheet"
        href="{{ asset('css/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/components.css') }}">

    <style>
        /* Mengubah latar belakang utama dashboard dan teks dasar */
        body {
            background-color: #FAF6F1 !important;
            color: #4A3225 !important;
        }
        
        /* Mengubah scrollbar bawaan browser agar estetik sewarna kopi */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #FAF6F1;
        }
        ::-webkit-scrollbar-thumb {
            background: #A67B5B;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6F4E37;
        }

        /* Override global untuk elemen tombol utama (Primary Button) */
        .btn-primary {
            background-color: #A67B5B !important;
            border-color: #A67B5B !important;
            box-shadow: 0 2px 6px rgba(166, 123, 91, 0.2) !important;
        }
        .btn-primary:hover, 
        .btn-primary:focus, 
        .btn-primary:active, 
        .btn-primary.active {
            background-color: #6F4E37 !important;
            border-color: #6F4E37 !important;
            box-shadow: 0 2px 6px rgba(111, 78, 55, 0.3) !important;
        }
        
        /* Override global warna link/tautan */
        a {
            color: #A67B5B;
        }
        a:hover {
            color: #6F4E37;
            text-decoration: none;
        }
    </style>

    <script async
        src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        fn_gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    </head>

<body>
    <div id="app">
        <div class="main-wrapper">
            @include('components.header')

            @include('components.sidebar')

            @yield('main')

            @include('components.footer')
        </div>
    </div>

    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    @stack('scripts')

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>