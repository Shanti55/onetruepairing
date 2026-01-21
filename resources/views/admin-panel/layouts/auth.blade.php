<!DOCTYPE html>
<html lang="en" data-bs-theme="light" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('images/logo.png')}}">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>

    @vite('resources/js/jquery.js')
    @vite(['resources/sass/app.scss','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />




</head>


<body class="h-100 auth-bg">

<div class="d-flex min-h-full flex-column justify-content-center">
    <div class="mt-10 mx-auto auth-container px-4">
{{--        <div class="d-flex align-items-center justify-content-center mb-3">--}}
{{--            <a href="/">--}}
{{--                <h1>CtrlF</h1>--}}
{{--            </a>--}}
{{--        </div>--}}

        @yield('content')
    </div>
</div>


</body>
