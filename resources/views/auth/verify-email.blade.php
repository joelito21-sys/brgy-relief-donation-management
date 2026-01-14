@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Verify Your Email Address</h1>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 font-medium text-sm text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6 text-sm text-gray-600">
            <p class="mb-2">{{ __('We have sent a 6-digit verification code to your email address.') }}</p>
            <p>{{ __('Please enter the code below to verify your email.') }}</p>
        </div>

        <form method="POST" action="{{ route('verification.verify') }}">
            @csrf

            <div class="mb-4">
                <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('Verification Code') }}
                </label>
                <div class="mt-1">
                    <input 
                        id="otp" 
                        type="text" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('otp') border-red-500 @enderror" 
                        name="otp" 
                        value="{{ old('otp') }}" 
                        required 
                        autofocus
                        maxlength="6"
                        pattern="\d{6}"
                        title="Please enter a 6-digit number"
                        placeholder="Enter 6-digit code"
                        inputmode="numeric"
                    >

                    @error('otp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Verify Email') }}
                </button>

                <div class="flex items-center space-x-4">
                    <form method="POST" action="{{ route('verification.resend') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 focus:outline-none">
                            {{ __('Resend Code') }}
                        </button>
                    </form>

                    <span class="text-gray-400">|</span>

                    <form method="POST" action="{{ route('resident.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 focus:outline-none">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
