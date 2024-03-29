@extends('layouts.app')

@section('content')
  <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
    <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2 mx-auto">
      <div class="w-full">

        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
          {{ __('Confirm Password') }}
        </h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" :errors="$errors" />

        <p>
          {{ __('Please confirm your password before continuing.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
          @csrf

          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">{{ __('New Password') }}</span>
            <x-input type="password" name="password" placeholder="***************" required aria-autocomplete="off" />

          </label>

          <button
            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            type="submit">
            {{ __('Confirm Password') }}
          </button>
        </form>

        @if (Route::has('password.request'))
          <hr class="my-8" />
          <p class="mt-4">
            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
              href="{{ route('password.request') }}">
              {{ __('Forgot Your Password?') }}
            </a>

          </p>
        @endif
      </div>
    </div>
  </div>
@endsection
