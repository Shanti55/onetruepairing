@extends('errors.layout')

@section('title', 'Access Denied | CtrlF')

@section('content')
    <div class="min-h-screen flex flex-col justify-center items-center text-center p-6 mt-5">
        <h1 class="text-6xl font-bold text-yellow-600 mt-5">403</h1>
        <p class="text-2xl mt-4">You do not have permission to view this page.</p>
        <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-600  px-6 py-3 rounded hover:bg-blue-700 transition">
            Return Home
        </a>
    </div>
@endsection
