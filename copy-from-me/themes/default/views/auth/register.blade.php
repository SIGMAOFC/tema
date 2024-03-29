@extends('layouts.app')
@section('content')
  <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
    <div class="flex flex-col overflow-y-auto md:flex-row">
      @if (config('SETTINGS::SYSTEM:ENABLE_LOGIN_LOGO'))
        <div class="h-32 md:h-auto md:w-1/2">
          <img aria-hidden="true" class="object-cover w-full h-full"
            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->exists('logo.png') ? \Illuminate\Support\Facades\Storage::url('logo.png') : asset('images/login-dark.jpeg') }}"
            alt="{{ config('app.name', 'Controlpanel.gg') }} Logo" />
        </div>
      @endif
      <div class="{{ config('SETTINGS::SYSTEM:ENABLE_LOGIN_LOGO') ? 'md:w-1/2 ' : 'w-full ' }}">
        <div class="w-full p-6 sm:p-12 ">
          <!-- Validation Errors -->
          <x-validation-errors class="mb-4" :errors="$errors" />

          @if (!config('SETTINGS::SYSTEM:CREATION_OF_NEW_USERS'))
            <x-alert title="The system administrator has blocked the registration of new users!" type="info">
            </x-alert>
          @else
            <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
              {{ __('Create Account') }}
            </h1>
            @if ($errors->has('ptero_registration_error'))
              @foreach ($errors->get('ptero_registration_error') as $err)
                <span class="text-red-600" role="alert">
                  <small><strong>{{ $err }}</strong></small>
                </span>
              @endforeach
            @endif
            <form method="POST" action="{{ route('register') }}">
              @csrf

              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">{{ __('Username') }}</span>
                <x-input placeholder="{{ __('Username') }}" type="text" id="name" name="name"
                  value="{{ old('name') }}" required autofocus />

              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">{{ __('Email') }}</span>
                <x-input type="email" name="email" id="email" value="{{ old('email') }}"
                  placeholder="{{ __('foo@gmail.com') }}" required />

              </label>
              <div class="flex gap-4 mt-4">
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">{{ __('Password') }}</span>
                  <x-input type="password" name="password" placeholder="***************" required />

                </label>
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    {{ __('Confirm password') }}
                  </span>
                  <x-input type="password" name="password_confirmation" placeholder="***************" required />

                </label>
              </div>
              @if (config('SETTINGS::REFERRAL::ENABLED') == 'true')
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    {{ __('Referral Code (optional)') }}
                  </span>
                  <x-input placeholder="" type="text" name="referral_code" value="{{ \Request::get('ref') }}" />

                </label>
              @endif

              @if (config('SETTINGS::RECAPTCHA:ENABLED') == 'true')
                <div class="block mt-6 text-sm">
                  {!! htmlFormSnippet() !!}
                </div>
              @endif

              <div class="flex mt-6 text-sm">
                <label class="flex items-center dark:text-gray-400">
                  <input name="terms" value="agree" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                  <span class="ml-2">
                    {{ __('I agree to the') }}
                    <a target="_blank" href="{{ route('tos') }}">{{ __('Terms of Service') }}</a>

                  </span>
                </label>
              </div>

              <!-- You should use a button here, as the anchor is only used for the example  -->
              <button
                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                type="submit">
                {{ __('Create account') }}
              </button>

            </form>
          @endif

          <hr class="my-8" />

          <p class="mt-4">
            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
              href="{{ route('login') }}">
              {{ __('Already registered? login') }}
            </a>
          </p>
        </div>
        <x-information />
      </div>
    </div>
  </div>
@endsection
