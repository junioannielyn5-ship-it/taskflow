
@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh]">
    <div class="bg-white rounded-lg shadow-lg p-10 w-full max-w-md text-center">
        <h1 class="text-6xl font-extrabold text-blue-600 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Page Not Found</h2>
        <p class="text-gray-500 mb-6">Sorry, the page you are looking for could not be found.</p>
        <a href="/" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Go Home</a>
    </div>
    <div class="mt-8">
        <img src="https://illustrations.popsy.co/gray/web-error.svg" alt="404 Illustration" class="w-64 mx-auto" />
    </div>
</div>
@endsection
