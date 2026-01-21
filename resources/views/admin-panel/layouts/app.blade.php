<!DOCTYPE html>
<html lang="en" data-bs-theme="light" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('images/logo.png')}}">

    @routes

    @vite('resources/js/jquery.js')
{{--    @vite('resources/js/jqueryui.js')--}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
</head>

<body>
<div class="wrapper">


    @include('admin-panel.layouts.partials._sidebar')

    <div class="main">

        @include('admin-panel.layouts.partials._navbar')

        <main class="content px-md-3 px-0 py-3">
            @yield('content')
        </main>
    </div>
</div>
@stack('js')



@livewireScripts
</body>

</html>
