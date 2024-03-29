@extends('layouts.app')
@section('content')
  <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
    <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2 mx-auto">
      <div class="w-full">

        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
          {{ __('Verify Your Email Address') }}
        </h1>
        @if (session('resent'))
          <x-alert type="success"
            title="
            {{ __('A fresh verification link has been sent to your email address.') }}">
          </x-alert>
        @endif

        <p>
          {{ __('Before proceeding, please check your email for a verification link.') }}
        </p>

        <form method="POST" action="{{ route('verification.resend') }}">
          @csrf

          <button
            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            type="submit">
            {{ __('Request Verification Link') }}
          </button>
        </form>

        <hr class="my-8" />
        <p class="mt-4">
          @if (Route::has('login'))
            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
              href="{{ route('login') }}">
              {{ __('Login') }}
            </a>
          @endif
        </p>
        <p class="mt-1">
          <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
            href="{{ route('register') }}">
            {{ __('Create Account') }}
          </a>
        </p>
      </div>
    </div>
  </div>
@endsection
