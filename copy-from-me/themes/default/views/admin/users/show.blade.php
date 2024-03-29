@extends('layouts.main')
@section('head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
@endsection

@section('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
@endsection
@section('content')
  <div class="container mx-auto grid">
    <div class="ease-soft-in-out xl:ml-68.5 relative transition-all duration-200 text-gray-700 dark:text-gray-200">

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
                <p class="mb-0 font-semibold leading-normal text-sm">{{ $user->email }} <span
                    class="px-2 py-1 ml-3 text-xs font-bold leading-tight rounded-full {{ $badgeColor }}">{{ $user->role }}</span>
                </p>
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
        <div class="grid gap-6">
          <div
            class="relative flex flex-col h-full min-w-0 break-words bg-white dark:bg-gray-800 border-0 shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 bg-white dark:bg-gray-800 border-b-0 rounded-t-2xl">
              <div class="flex flex-wrap -mx-3">
                <div class="flex items-center w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
                  <h2 class="font-bold">{{ __('Profile Information') }}</h2>

                </div>
              </div>
              <div class="grid gap-6 mb-8 md:grid-cols-2 mt-2 ">
                <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
                  <table class="w-full whitespace-no-wrap">
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('ID') }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          {{ $user->id }}
                        </td>
                      </tr>

                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Pterodactyl ID') }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          {{ $user->pterodactyl_id }}
                        </td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Email') }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          {{ $user->email }}
                        </td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ CREDITS_DISPLAY_NAME }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          {{ $user->Credits() }}
                        </td>
                      </tr>

                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ CREDITS_DISPLAY_NAME }} {{ __('Usage') }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          {{ $user->CreditUsage() }} / Per Month
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
                  <table class="w-full whitespace-no-wrap">
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Server Limit') }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          {{ $user->Servers()->count() }} / {{ $user->server_limit }}
                        </td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Verified') }} {{ __('Email') }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          {{ $user->email_verified_at ? 'Yes' : 'No' }}
                        </td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Verified') }} {{ __('Discord') }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          {{ $user->discordUser ? 'Yes' : 'No' }}
                        </td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('IP') }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          {{ $user->ip }}
                        </td>
                      </tr>

                      <tr class="text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Last Seen') }}
                            </p>
                          </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                          @if ($user->last_seen)
                            {{ $user->last_seen->diffForHumans() }}
                          @else
                            <small class="text-muted">Null</small>
                          @endif
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            @if ($user->discordUser)
              <div class="p-4 pt-0">
                <div class="flex flex-wrap -mx-3 mb-2">
                  <div class="flex items-center w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
                    <h2 class="font-bold">{{ __('Discord Information') }}</h2>

                  </div>
                </div>
                <div class="flex items-center space-x-4 p-4 rounded-lg dark:bg-gray-700 bg-gray-100">
                  <img class="w-10 h-10 rounded-full" src="{{ $user->discordUser->getAvatar() }}"
                    alt="{{ $user->discordUser->username }}'s Avatar">
                  <div class="font-medium dark:text-white">
                    <div>{{ $user->discordUser->username }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                      {{ $user->discordUser->id }}
                    </div>
                  </div>
                </div>

              </div>
            @endif
          </div>


        </div>
      </div>
    </div>
  </div>

  <x-container title="Referrals (Code: {{ $user->referral_code }})">
    <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
      <table class="w-full whitespace-no-wrap">
        <thead>
          <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-600 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <td class="px-4 py-3">{{ __('User ID') }}</td>
            <td class="px-4 py-3">{{ __('User') }}</td>
            <td class="px-4 py-3">{{ __('Created At') }}</td>
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          @forelse ($referrals as $referral)
            <tr class="text-gray-700 dark:text-gray-300">
              <td class="px-4 py-3">
                <div class="flex items-center text-sm">
                  <p class="font-semibold">
                    {{ $referral->id }}
                  </p>
                </div>
              </td>

              <td class="px-4 py-3 text-sm">
                <a href="{{ route('admin.users.show', $referral->id) }}"
                  class="underline text-purple-600">{{ $referral->name }}</a>
              </td>
              <td class="px-4 py-3 text-sm">
                {{ $referral->created_at->diffForHumans() }}
              </td>
            </tr>
          @empty
            <tr class="text-gray-700 dark:text-gray-300">
              <td class="px-4 py-3" colspan="3">
                <div class="flex items-center text-sm">
                  No Referrals Found
                </div>
              </td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>
  </x-container>
  <div class="container px-6 mx-auto grid">

    <div class="flex justify-between py-6">

      <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
        {{ __('Servers') }}
      </h2>
    </div>
    @include('admin.servers.table', ['filter' => '?user=' . $user->id])
  </div>

  <script>
    function onClickCopy() {
      let textToCopy = document.getElementById('RefLink').innerText;
      if (navigator.clipboard) {
        navigator.clipboard.writeText(textToCopy).then(() => {
          Swal.fire({
            icon: 'success',
            title: '{{ __('URL copied to clipboard') }}',
            position: 'top-middle',
            showConfirmButton: false,
            background: '#343a40',
            toast: false,
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
