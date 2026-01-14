@extends('layouts.auth')

@section('title', __('Reset Password'))

@push('styles')
    <style>
        /* Add any custom styles here */
    </style>
@endpush

@section('subtitle', __('Enter your new password below.'))

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('Reset Password') }}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ __('Enter your new password below.') }}
            </p>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('donor.password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-4">
                    <label for="email" class="sr-only">{{ __('Email Address') }}</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 
                                  placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 
                                  focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror" 
                           value="{{ $email ?? old('email') }}" readonly>
                    
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="sr-only">{{ __('New Password') }}</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 
                                  placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 
                                  focus:border-indigo-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror" 
                           placeholder="{{ __('New Password') }}">
                    
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="sr-only">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" name="password_confirmation" type="password" 
                           autocomplete="new-password" required
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 
                                  placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none 
                                  focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                           placeholder="{{ __('Confirm Password') }}">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent 
                                            text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
@endsection
