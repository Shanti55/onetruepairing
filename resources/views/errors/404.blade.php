@extends('errors.layout')

@section('title', 'Page Not Found | CtrlF')

@section('content')
    <div class="min-h-screen flex flex-col justify-center items-center text-center p-6 mt-5">
        <h1 class="text-6xl font-bold text-red-600 mt-5">404</h1>
        <p class="text-2xl mt-4">Oops! The page you are looking for doesn’t exist.</p>
        <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-600  px-6 py-3 rounded hover:bg-blue-700 transition">
            Go to Homepage
        </a>
    </div>
@endsection
