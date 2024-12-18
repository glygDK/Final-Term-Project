@extends('mainLayout')

@section('title', 'Login')

@section('content')
<div class="container mx-auto p-4 max-w-md space-y-4 mt-24">
    <h1 class="text-3xl font-semibold mb-6">Login to Your Account</h1>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input id="email" name="email" type="email" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" required
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Login
            </button>
        </div>
    </form>


    <div class="space-y-2">
        <form action="#" method="POST" class="">
            @csrf
            <button type="submit"
                class="flex w-full items-center justify-center gap-2 bg-white border-2 text-black py-2 rounded-md hover:bg-neutral-100 focus:outline-none">
                <img src="{{ asset('images/google.png') }}" class="object-cover">
                <p>Sign in to Google</p>
            </button>
        </form>
        <form action="#" method="POST" class="">
            @csrf
            <button type="submit"
                class="flex w-full items-center justify-center gap-2 bg-white border-2 border-blue-400 text-black py-2 rounded-md hover:bg-blue-400 hover:text-white focus:outline-none">
                <img src="{{ asset('images/facebook.png') }}" class="object-cover">
                <p>Sign in to Facebook</p>
            </button>
        </form>
    </div>

    <p class="mt-4 text-center text-sm text-gray-600">
        Don't have an account? <a href="{{ route('register') }}"
            class="text-indigo-600 hover:text-indigo-700">Register</a>
    </p>
</div>

@endsection
