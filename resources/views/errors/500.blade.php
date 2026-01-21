@extends('errors.layout')

@section('title', 'Server Error | CtrlF')

@section('content')
    <div class="min-h-screen flex flex-col justify-center items-center text-center p-6 mt-5">
        <h1 class="text-6xl font-bold text-red-600 mt-5">500</h1>
        <p class="text-2xl mt-4">Sorry! Something went wrong on our end.</p>
        <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-600 px-6 py-3 rounded hover:bg-blue-700 transition">
            Try Again Later
        </a>
    </div>
@endsection
