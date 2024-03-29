@extends('layouts.main')

@section('content')

  <div class="container mx-auto grid">
    <div class="ease-soft-in-out xl:ml-68.5 relative transition-all duration-200 text-gray-700 dark:text-gray-200">

      @if (is_null(Auth::user()->discordUser) && strtolower($force_discord_verification) == 'true')
        @if (!empty(config('SETTINGS::DISCORD:CLIENT_ID')) && !empty(config('SETTINGS::DISCORD:CLIENT_SECRET')))
          <x-alert class="mt-6" type="danger" title="Required Discord verification">
            <p>
              {{ __('You have not yet verified your discord account') }} <br>
              <a class="text-primary underline" href="{{ route('auth.redirect') }}">{{ __('Login with discord') }}</a>
              <br>
              {{ __('Please contact support If you face any issues.') }}
            </p>
          </x-alert>
        @else
          <x-alert class="mt-6" type="danger" title="Required Discord verification">
            <p>
              {{ __('Due to system settings you are required to verify your discord account!') }} <br>
              {{ __('It looks like this hasnt been set-up correctly! Please contact support.') }}
            </p>
          </x-alert>
        @endif
      @endif

      <div class="w-full px-6 mx-auto">
        <div class="relative flex items-center p-0 mt-6 overflow-hidden bg-center bg-cover min-h-75 rounded-2xl"
          style="background-image: url('{{ asset('images/user_profile_bg.jpg') }}'); background-position-y: 50%; height: 200px;">
          <span
            class="absolute inset-y-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-700 to-pink-500 opacity-60"></span>
        </div>
        <div
          class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 -mt-16 overflow-hidden break-words border-0 shadow-blur rounded-2xl bg-white/80 dark:bg-gray-800/80 bg-clip-border backdrop-blur-2xl backdrop-saturate-200">
          <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-auto max-w-full px-3">
              <div
                class="text-base ease-soft-in-out h-18.5 w-18.5 relative inline-flex items-center justify-center rounded-xl text-white transition-all duration-200">
                <img src="{{ $user->getAvatar() }}" alt="profile_image" class="w-full shadow-soft-sm rounded-xl">
              </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
              <div class="h-full">
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="mb-0 font-semibold leading-normal text-sm">{{ $user->email }}</p>
              </div>
            </div>
            <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 md:w-1/2 md:flex-none lg:w-4/12">
              <div class="relative right-0">
                <ul class="relative flex flex-wrap p-1 list-none bg-transparent rounded-xl flex-col on-resize"
                  nav-pills="" role="tablist">
                  <li class="z-30 flex-auto text-center">
                    <span
                      class="z-30 block w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-gray-700 dark:text-gray-200">
                      {{ $user->Credits() }} {{ CREDITS_DISPLAY_NAME }}
                    </span>
                  </li>
                  <li class="z-30 flex-auto text-center">

                    <small>{{ $user->created_at->isoFormat('LL') }}</small>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full p-6 mx-auto">
        <div class="grid gap-6 mb-8 md:grid-cols-2">
          <div
            class="relative flex flex-col h-full min-w-0 break-words bg-white dark:bg-gray-800 border-0 shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 bg-white dark:bg-gray-800 border-b-0 rounded-t-2xl">
              <div class="flex flex-wrap -mx-3">
                <div class="flex items-center w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
                  <h2 class="font-bold">{{ __('Profile Information') }}</h2>

                </div>
              </div>
            </div>
            <div class="p-4 pb-0">
              <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                <li
                  class="relative block px-4 py-2 pt-0 pl-0 leading-normal bg-white dark:bg-gray-800 border-0 rounded-t-lg text-sm text-inherit">
                  <strong class="text-gray-700 dark:text-gray-200">User Name:</strong> &nbsp;
                  {{ $user->name }}
                </li>
                <li
                  class="relative block px-4 py-2 pl-0 leading-normal bg-white dark:bg-gray-800 border-0 border-t-0 text-sm text-inherit">
                  <strong class="text-gray-700 dark:text-gray-200">Email:</strong> &nbsp;
                  {{ $user->email }}
                </li>
                @if (config('SETTINGS::REFERRAL::ENABLED') == 'true')
                  <li data-content="Click to Copy" data-toggle="popover" data-trigger="hover" data-placement="top"
                    onclick="onClickCopy('{{ route('register') }}?ref={{ $user->referral_code }}')"
                    class="cursor-copy text-gray-700 dark:text-gray-200 hover:text-gray-600 hover:dark:text-gray-400 relative block px-4 py-2 pl-0 leading-normal bg-white dark:bg-gray-800 border-0 border-t-0 text-sm text-inherit">
                    @if (
                        (config('SETTINGS::REFERRAL::ALLOWED') == 'client' && $user->role != 'member') ||
                            config('SETTINGS::REFERRAL::ALLOWED') == 'everyone')
                      <strong class="">Referral URL:</strong> &nbsp;
                      {{ route('register') }}?ref={{ $user->referral_code }}
                    @else
                      <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full badge-warning">
                        {{ _('Make a purchase to reveal your referral-URL') }}</span>
                    @endif
                  </li>
                @endif
                <li
                  class="relative block px-4 py-2 pl-0 leading-normal bg-white dark:bg-gray-800 border-0 border-t-0 text-sm text-inherit">
                  <strong class="text-gray-700 dark:text-gray-200">Role:</strong> &nbsp; <span
                    class="px-2 py-1 text-xs font-semibold leading-tight rounded-full {{ $badgeColor }}">{{ $user->role }}</span>
                </li>
                <li
                  class="relative block px-4 py-2 pt-0 pl-0 leading-normal bg-white dark:bg-gray-800 border-0 rounded-t-lg text-sm text-inherit">
                  <strong class="text-gray-700 dark:text-gray-200">Created At:</strong> &nbsp;
                  {{ $user->created_at->isoFormat('LL') }}
                </li>
              </ul>
            </div>

            <x-button class="mx-4 my-2 bg-red-500 hover:bg-red-600 text-white w-1/3" id="confirmDeleteButton"
              type="button">{{ __('Delete Account') }}</x-button>
            @if (!empty(config('SETTINGS::DISCORD:CLIENT_ID')) && !empty(config('SETTINGS::DISCORD:CLIENT_SECRET')))
              <div class="p-4 pt-0 mt-4">
                @if (is_null(Auth::user()->discordUser))
                  <b>{{ __('Link your discord account!') }}</b>
                  <div class="verify-discord">
                    <div class="mb-3">
                      @if ($credits_reward_after_verify_discord)
                        <p>
                          {{ __('By verifying your discord account, you receive extra Credits and increased Server amounts') }}
                        </p>
                      @endif
                    </div>
                  </div>

                  <a class="text-purple-600 underline" href="{{ route('auth.redirect') }}">
                    {{ __('Login with Discord') }}
                  </a>
                @else
                  <div class="verified-discord">
                    <div class="my-3 callout callout-info">
                      <p>{{ __('You are verified!') }}</p>
                    </div>
                  </div>
                  <div class="flex items-center space-x-4 p-4 rounded-lg dark:bg-gray-700 bg-gray-100">
                    <img class="w-10 h-10 rounded-full" src="{{ $user->discordUser->getAvatar() }}"
                      alt="{{ $user->discordUser->username }}'s Avatar">
                    <div class="font-medium dark:text-white">
                      <div>{{ $user->discordUser->username }}</div>
                      <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $user->discordUser->id }} <a href="{{ route('auth.redirect') }}"
                          class="text-purple-600 underline">{{ __('Re-Sync Discord') }}
                        </a></div>
                    </div>
                  </div>
                @endif

              </div>
            @endif
          </div>
          <div
            class="relative flex flex-col h-full min-w-0 break-words bg-white dark:bg-gray-800 border-0 shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 bg-white dark:bg-gray-800 border-b-0 rounded-t-2xl">
              <h2 class="font-bold">{{ __('Settings') }}</h2>
            </div>
            <div class="flex-auto p-4">
              <form class="form" action="{{ route('profile.update', Auth::user()->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="card">
                  <div class="card-body">
                    <div class="e-profile">

                      <div class="tab-content">



                        <!-- Validation Errors -->
                        <x-validation-errors class="mb-4" :errors="$errors" />

                        <label class="block text-sm mb-3">
                          <span class="text-gray-700 dark:text-gray-400">{{ __('Name') }}</span>
                          <input x-todo="name" id="name" name="name" type="text"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                                                        @error('name') border-red-300 focus:ring-red-200 @enderror"
                            value="{{ $user->name }}" placeholder="{{ $user->name }}">
                        </label>

                        <label class="block text-sm mb-3">
                          <span class="text-gray-700 dark:text-gray-400">{{ __('Email') }}</span>
                          <input x-todo="email" id="email" name="email" type="text"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                                                        @error('email') border-red-300 focus:ring-red-200 @enderror"
                            value="{{ $user->email }}" placeholder="{{ $user->email }}">
                        </label>

                        <div class="row">
                          <div class="col-12 col-sm-6 mb-3">
                            <h2 class="mb-3">{{ __('Change Password') }}</h2>
                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <label class="block text-sm mb-3">
                                    <span class="text-gray-700 dark:text-gray-400">{{ __('Current Password') }}</span>
                                    <input x-todo="current_password" id="current_password" name="current_password"
                                      type="text"
                                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                                                            @error('current_password') border-red-300 focus:ring-red-200 @enderror"
                                      placeholder="••••••">
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <label class="block text-sm mb-3">
                                    <span class="text-gray-700 dark:text-gray-400">{{ __('New Password') }}</span>
                                    <input x-todo="new_password" id="new_password" name="new_password" type="text"
                                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                                                            @error('new_password') border-red-300 focus:ring-red-200 @enderror"
                                      placeholder="••••••">
                                  </label>

                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <div class="form-group">

                                  <label class="block text-sm mb-3">
                                    <span class="text-gray-700 dark:text-gray-400">{{ __('Confirm Password') }}</span>
                                    <input x-todo="new_password_confirmation" id="new_password_confirmation"
                                      name="new_password_confirmation" type="text"
                                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                                                            @error('new_password_confirmation') border-red-300 focus:ring-red-200 @enderror"
                                      placeholder="••••••">
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col d-flex justify-content-end">

                            <button
                              class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                              type="submit">{{ __('Save Changes') }}</button>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById("confirmDeleteButton").onclick = async () => {
      const {
        value: enterConfirm
      } = await Swal.fire({
        background: '#343a40',
        input: 'text',
        inputLabel: '{{ __('Are you sure you want to permanently delete your account and all of your servers?') }} \n Type "{{ __('Delete my account') }}" in the Box below',
        inputPlaceholder: "{{ __('Delete my account') }}",
        showCancelButton: true
      })
      if (enterConfirm === "{{ __('Delete my account') }}") {
        Swal.fire("{{ __('Account has been destroyed') }}", '', 'error')
        $.ajax({
          type: "POST",
          url: "{{ route('profile.selfDestroyUser') }}",
          data: `{
                    "confirmed": "yes",
                    }`,
          success: function(result) {
            console.log(result);
          },
          dataType: "json"
        });
        location.reload();

      } else {
        Swal.fire("{{ __('Account was NOT deleted.') }}", '', 'info')

      }

    }

    function onClickCopy(textToCopy) {
      if (navigator.clipboard) {
        navigator.clipboard.writeText(textToCopy).then(() => {
          Swal.fire({
            icon: 'success',
            title: '{{ __('URL copied to clipboard') }}',
            position: 'bottom-right',
            showConfirmButton: false,
            background: '#343a40',
            toast: true,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
        })
      } else {
        console.log('Browser Not compatible')
      }
    }
  </script>
@endsection
