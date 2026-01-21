@extends('errors.layout')

@section('title', 'Too Many Requests | CtrlF')

@section('content')
    <div class="min-h-screen flex flex-col justify-center items-center text-center p-6 mt-5">
        <h1 class="text-6xl font-bold text-yellow-500 mt-5">429</h1>
        <p class="text-2xl mt-4">You’re sending too many requests. Please slow down.</p>
        <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-600 px-6 py-3 rounded hover:bg-blue-700 transition">
            Return to Homepage
        </a>
    </div>
@endsection
