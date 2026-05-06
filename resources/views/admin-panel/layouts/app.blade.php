<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="icon" href="{{asset('images/logo.png')}}">

    @routes

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- VITE -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    @livewireStyles
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

<!-- AJAX GLOBAL SETUP -->
<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

/* EASY AJAX FUNCTION */

$.easyAjax = function(options) {

    $.ajax({
        url: options.url,
        type: options.type || 'GET',
        data: options.data || {},
        processData: false,
        contentType: false,

        success: function(response) {

            if(options.onComplete){
                options.onComplete(response);
            }

        },

        error: function(error){
            console.error(error);
        }

    });

};

/* EASY DELETE FUNCTION */

$.easyDelete = function(options) {

    if(confirm(options.confirmationMessage)){

        $.ajax({

            url: options.url,
            type: 'DELETE',

            success: function(response){

                if(options.onComplete){
                    options.onComplete(response);
                }

            }

        });

    }

};

</script>

@livewireScripts

</body>
</html>