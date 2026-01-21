<!DOCTYPE html>
<html lang="en" data-bs-theme="light" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('images/logo.png')}}">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>

    @routes

   
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery (already hai, fir bhi ensure) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <meta name="csrf-token" content="{{ csrf_token() }}">


    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


</head>

<body>
<div class="wrapper">
    @include('service-provider-panel.layouts.partials._sidebar')

    <div class="main">

        @include('service-provider-panel.layouts.partials._navbar')

        <main class="content px-3 py-3">
            @yield('content')
        </main>


    </div>
</div>
@stack('js')
@livewireScripts
</body>

</html>
