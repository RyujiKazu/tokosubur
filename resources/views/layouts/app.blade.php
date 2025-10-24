<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title','Dashboard - SB Admin')</title>

    {{-- CSS utama dari template --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    {{-- DataTables CSS (CDN) --}}
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"
          rel="stylesheet" crossorigin="anonymous" />

    {{-- Font Awesome (CDN) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
            crossorigin="anonymous"></script>

    @stack('head')
  </head>
  <body class="sb-nav-fixed">
    @yield('content')

    {{-- jQuery + Bootstrap 4 bundle (CDN) --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>

    {{-- Script utama template --}}
    <script src="{{ asset('js/scripts.js') }}"></script>

    {{-- Chart.js + demo charts (CDN + lokal) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
            crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>

    {{-- DataTables (CDN) + demo init lokal --}}
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"
            crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/datatables-demo.js') }}"></script>

    @stack('scripts')
  </body>
</html>