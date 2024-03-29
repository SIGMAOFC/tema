@extends('layouts.app')
@section('content')
  <div
    class="{{ (config('SETTINGS::SYSTEM:ENABLE_LOGIN_LOGO') ? 'max-w-4xl ' : 'max-w-[40rem] ') . 'flex-1 h-full  mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800' }}">
    <div class="flex flex-col overflow-y-auto md:flex-row">
      @if (config('SETTINGS::SYSTEM:ENABLE_LOGIN_LOGO'))
        <div class="h-32 md:h-auto md:w-1/2">
          <img aria-hidden="true" class="object-cover w-full h-full"
            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->exists('logo.png') ? \Illuminate\Support\Facades\Storage::url('logo.png') : asset('images/login-dark.jpeg') }}"
            alt="{{ config('app.name', 'Controlpanel.gg') }} Logo" />
        </div>
      @endif
      <div class="{{ config('SETTINGS::SYSTEM:ENABLE_LOGIN_LOGO') ? 'md:w-1/2 ' : 'w-full ' }}">
        <div class="w-full p-6 sm:p-12">
          <!-- Session Status -->
          <x-auth-session-status class="mb-4" :status="session('status')" />

          @if (session('message'))
            <div class="font-medium text-red-600">
              {{ session('message') }}
            </div>
          @endif

          <!-- Validation Errors -->
          <x-validation-errors class="mb-4" :errors="$errors" />

          <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Login') }}
          </h1>
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <label class="block text-sm">
              <span class="text-gray-700 dark:text-gray-400">{{ __('Email') }}</span>
              <x-input type="email" name="email" value="{{ old('email') }}" required autofocus />
            </label>
            <label class="block mt-4 text-sm">
              <span class="text-gray-700 dark:text-gray-400">{{ __('Password') }}</span>
              <x-input type="password" name="password" required autocomplete="current-password" />
            </label>

            <div class="block mt-4">
              <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                  class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
              </label>
            </div>

            @if (config('SETTINGS::RECAPTCHA:ENABLED') == 'true')
              <div class="block mt-4">
                {!! htmlFormSnippet() !!}
              </div>
            @endif

            <button
              class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
              type="submit">
              {{ __('Log in') }}
            </button>
          </form>

          <hr class="my-8" />
          <div class="flex justify-between mt-4">
            <p>
              @if (Route::has('password.request'))
                <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                  href="{{ route('password.request') }}">
                  {{ __('Forgot your password?') }}
                </a>
              @endif
            </p>
            <p>
              <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                href="{{ route('register') }}">
                {{ __('Create Account') }}
              </a>
            </p>
          </div>
        </div>

        <x-information />
      </div>
    </div>
  </div>
@endsection
