@extends('layouts.main')
@section('content')
  <div class="container px-6 mx-auto">

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      {{ __('Dashboard') }}
    </h2>
    @if (config('SETTINGS::SYSTEM:ALERT_ENABLED') && !empty(config('SETTINGS::SYSTEM:ALERT_MESSAGE')))
      <x-alert type="{{ config('SETTINGS::SYSTEM:ALERT_TYPE') }}" title="">
        <div class="noreset">
          {!! config('SETTINGS::SYSTEM:ALERT_MESSAGE') !!}
        </div>
      </x-alert>
    @endif
    <div
      class="grid gap-6 mb-8 @if ($credits > 0.01 and $usage > 0) md:grid-cols-2 xl:grid-cols-4 @else md:grid-cols-2 xl:grid-cols-3 @endif">
      <!-- Card -->
      <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
          <!-- heroicons icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ __('Servers') }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ Auth::user()->servers()->count() }}
          </p>
        </div>
      </div>
      <!-- Card -->
      <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
              clip-rule="evenodd"></path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ CREDITS_DISPLAY_NAME }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ Auth::user()->Credits() }}
          </p>
        </div>
      </div>
      <!-- Card -->
      <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
            </path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ CREDITS_DISPLAY_NAME }} {{ __('Usage') }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ number_format($usage, 2, '.', '') }}
            <sup>{{ __('per month') }}</sup>
          </p>
        </div>
      </div>

      @if ($credits > 0.01 and $usage > 0)
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
          <div
            class="p-3 mr-4 text-violet-500 bg-violet-100 rounded-full dark:text-violet-100 dark:bg-violet-500 {{ $bg }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              {{ __('Out of Credits in', ['credits' => CREDITS_DISPLAY_NAME]) }}
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
              {{ $boxText }}
              <sup>{{ $unit }}</sup>
            </p>
          </div>
        </div>
      @endif

    </div>

    @if (config('SETTINGS::SYSTEM:MOTD_ENABLED') == 'true')
      <x-card title="{{ config('app.name', 'ControlPanel') }} - MOTD">
        <div class="unreset text-gray-700 dark:text-gray-200">

          {!! config('SETTINGS::SYSTEM:MOTD_MESSAGE', '') !!}
        </div>
      </x-card>
    @endif

    <div class="grid gap-6 mb-8 @if (config('SETTINGS::REFERRAL::ENABLED') || config('SETTINGS::SYSTEM:USEFULLINKS_ENABLED')) md:grid-cols-3 @endif">
      <div class="w-full overflow-hidden col-span-2 md:col-span-1">
        @if (config('SETTINGS::SYSTEM:USEFULLINKS_ENABLED') == 'true')
          <x-card title="Useful Links">
            @foreach ($useful_links_dashboard as $useful_link)
              <div class="mb-2">
                <h2 class="text-gray-700 dark:text-gray-200 font-semibold flex items-center">
                  <iconify-icon icon="{{ $useful_link->icon }}" height="24" width="24"
                    class="mr-2"></iconify-icon>
                  <a class="underline" target="__blank" href="{{ $useful_link->link }}">
                    {{ $useful_link->title }}
                  </a>
                </h2>
                <p class="ml-8 mb-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                  {!! $useful_link->description !!}
                </p>
              </div>
            @endforeach
          </x-card>
        @endif
        @if (config('SETTINGS::REFERRAL::ENABLED'))
          <x-card title="Partner Program">
            @if (
                (config('SETTINGS::REFERRAL::ALLOWED') == 'client' && Auth::user()->role != 'member') ||
                    config('SETTINGS::REFERRAL::ALLOWED') == 'everyone')
              <div>
                <li
                  class="text-gray-700 dark:text-gray-200  relative block leading-normal bg-white dark:bg-gray-800 border-0 border-t-0 text-sm text-inherit">

                  <strong class="">Referral Code:</strong>
                  <span class="cursor-copy hover:text-gray-600 hover:dark:text-gray-400" data-content="Click to Copy URL"
                    data-toggle="popover" data-trigger="hover" data-placement="top"
                    onclick="onClickCopy('{{ route('register') }}?ref={{ Auth::user()->referral_code }}')">
                    {{ Auth::user()->referral_code }} (Click to Copy URL)</span>

                </li>

                <li
                  class="text-gray-700 dark:text-gray-200  relative block leading-normal bg-white dark:bg-gray-800 border-0 border-t-0 text-sm text-inherit">

                  <strong class="">Referred Users: </strong>
                  <span>{{ $numberOfReferrals }}</span>

                </li>
              </div>
              @if ($partnerDiscount)
                <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
                  <table class="w-full whitespace-no-wrap">
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Your discount') }}
                            </p>
                          </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                          {{ $partnerDiscount->partner_discount }}%
                        </td>
                      <tr>
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Discount for your new users') }}
                            </p>
                          </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                          {{ $partnerDiscount->registered_user_discount }}%
                        </td>
                      </tr>
                      <tr>
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Reward per registered user') }}
                            </p>
                          </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                          {{ config('SETTINGS::REFERRAL::REWARD') }}
                          {{ config('SETTINGS::SYSTEM:CREDITS_DISPLAY_NAME') }}
                        </td>
                      </tr>
                      <tr>
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('New user payment commision') }}
                            </p>
                          </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                          {{ $partnerDiscount->referral_system_commission == -1 ? config('SETTINGS::REFERRAL:PERCENTAGE') : $partnerDiscount->referral_system_commission }}%
                        </td>
                      </tr>
                      </tr>
                    </tbody>
                  </table>
                </div>
              @else
                <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
                  <table class="w-full whitespace-no-wrap">
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('Reward per registered user') }}
                            </p>
                          </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                          {{ config('SETTINGS::REFERRAL::REWARD') }}
                          {{ config('SETTINGS::SYSTEM:CREDITS_DISPLAY_NAME') }}
                        </td>
                      <tr>
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <p class="font-semibold">
                              {{ __('New user payment commision') }}
                            </p>
                          </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                          {{ config('SETTINGS::REFERRAL:PERCENTAGE') }}%
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              @endif
            @else
              <span class="text-xs font-semibold leading-tight rounded-full badge-warning">
                {{ _('Make a purchase to reveal your referral-URL') }}</span>
            @endif
          </x-card>
        @endif
      </div>


      <div class="w-full overflow-hidden col-span-2">
        <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
          {{ __('Activity Logs') }}
        </h2>
        <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">{{ __('Log') }}</th>
                <th class="px-4 py-3">{{ __('Action') }}</th>
                <th class="px-4 py-3">{{ __('Time') }}</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              @foreach (Auth::user()->actions()->take(8)->orderBy('created_at', 'desc')->get() as $log)
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <p class="font-semibold">
                        {{ explode('\\', $log->subject_type)[2] }}
                        {{ $log->description }}
                        @php $first=true @endphp
                        @foreach (json_decode($log->properties, true) as $properties)
                          @if ($first)
                            @if (isset($properties['name']))
                              "{{ $properties['name'] }}"
                            @endif
                            @if (isset($properties['email']))
                              <<span>{{ $properties['email'] }}</span>>
                            @endif
                            @php $first=false @endphp
                          @endif
                        @endforeach
                      </p>
                    </div>
                  </td>

                  <td class="px-4 py-3 text-xs">
                    @if (str_starts_with($log->description, 'created'))
                      <span
                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-green-500 dark:bg-green-500/20">
                        Created
                      </span>
                    @elseif(str_starts_with($log->description, 'redeemed'))
                      <span
                        class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:text-blue-500 dark:bg-blue-500/20">
                        Redeemed
                      </span>
                    @elseif(str_starts_with($log->description, 'deleted'))
                      <span
                        class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-500 dark:bg-red-500/20">
                        Deleted
                      </span>
                    @elseif(str_starts_with($log->description, 'gained'))
                      <span
                        class="px-2 py-1 font-semibold leading-tight text-lime-700 bg-lime-100 rounded-full dark:text-lime-500 dark:bg-lime-500/20">
                        Gained
                      </span>
                    @elseif(str_starts_with($log->description, 'updated'))
                      <span
                        class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 dark:text-yellow-500 dark:bg-yellow-500/20 rounded-full">
                        Updated
                      </span>
                    @endif
                  </td>

                  <td class="px-4 py-3 text-sm">
                    {{ $log->created_at->diffForHumans() }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <script>
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
