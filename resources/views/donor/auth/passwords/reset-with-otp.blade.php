@extends('layouts.auth')

@section('title', 'Reset Password')

@section('subtitle', 'Create a new password for your account.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-teal-900">
                Reset Password
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Please enter your new password below.
            </p>
        </div>

        @if ($errors->any())
            <div class="rounded-md bg-red-50 p-4 mb-4">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="mt-8 space-y-6" method="POST" action="{{ route('donor.password.reset.process') }}">
            @csrf

            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input id="password" name="password" type="password" required
                           class="appearance-none rounded-md relative block w-full px-3 py-2 border border-teal-300 
                                  placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-teal-500 
                                  focus:border-teal-500 focus:z-10 sm:text-sm" 
                           placeholder="••••••••">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="appearance-none rounded-md relative block w-full px-3 py-2 border border-teal-300 
                                  placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-teal-500 
                                  focus:border-teal-500 focus:z-10 sm:text-sm" 
                           placeholder="••••••••">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent 
                                            text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
