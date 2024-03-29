<div class="py-4 text-gray-500 dark:text-gray-400">
  <a class="flex gap-4 items-center ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ route('home') }}">
    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('icon.png'))
      <img src="{{ asset('storage/icon.png') }}" alt="{{ config('app.name', 'ControlPanel.gg') }} Logo"
        class="rounded-lg w-9 h-9">
    @endif
    <span>
      {{ config('app.name', 'ControlPanel') }}
    </span>
  </a>
  <ul class="mt-6">
    <li class="relative px-6 py-3">
      @if (Request::routeIs('home'))
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
      @endif

      <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('home')) text-gray-800 dark:text-gray-100 @endif"
        href="{{ route('home') }}">
        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
          stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
          <path
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
          </path>
        </svg>
        <span class="ml-4">{{ __('Dashboard') }}</span>
      </a>
    </li>
  </ul>
  <ul>
    <li class="relative px-6 py-3">
      @if (Request::routeIs('servers.*'))
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
      @endif
      <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('servers.*')) text-gray-800 dark:text-gray-100 @endif"
        href="{{ route('servers.index') }}">
        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
          stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
          <path
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
          </path>
        </svg>
        <span class="ml-4">{{ __('Servers') }}</span>
        <span class="ml-auto text-xs rounded py-0.5 px-2 bg-gray-700/70 text-gray-300">
          {{ Auth::user()->servers()->count() }} /
          {{ Auth::user()->server_limit }}
        </span>
      </a>
    </li>
    @if (env('APP_ENV') == 'local' ||
            (config('SETTINGS::PAYMENTS:PAYPAL:SECRET') && config('SETTINGS::PAYMENTS:PAYPAL:CLIENT_ID')) ||
            (config('SETTINGS::PAYMENTS:STRIPE:SECRET') &&
                config('SETTINGS::PAYMENTS:STRIPE:ENDPOINT_SECRET') &&
                config('SETTINGS::PAYMENTS:STRIPE:METHODS')))
      <li class="relative px-6 py-3">
        @if (Request::routeIs('store.*'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('store.*')) text-gray-800 dark:text-gray-100 @endif"
          href="{{ route('store.index') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
            </path>
          </svg>
          <span class="ml-4">{{ __('Store') }}</span>
        </a>
      </li>
    @endif

    @if (config('SETTINGS::TICKET:ENABLED'))
      <li class="relative px-6 py-3">
        @if (Request::routeIs('ticket.*'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('ticket.*')) text-gray-800 dark:text-gray-100 @endif"
          href="{{ route('ticket.index') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
            </path>
          </svg>
          <span class="ml-4">{{ __('Support Ticket') }}</span>
        </a>
      </li>
    @endif

    @if ((Auth::user()->role == 'admin' || Auth::user()->role == 'moderator') && config('SETTINGS::TICKET:ENABLED'))
      <li class="relative px-6 py-1">
        <span class="text-sm font-bold">{{ __('Moderation') }}</span>
      </li>
      <li class="relative px-6 py-3">
        @if (Request::routeIs('moderator.ticket.index'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('moderator.ticket.index')) text-gray-800 dark:text-gray-100 @endif"
          href="{{ route('moderator.ticket.index') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
            </path>
          </svg>
          <span class="ml-4">{{ __('Ticket List') }}</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        @if (Request::routeIs('moderator.ticket.blacklist'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('moderator.ticket.blacklist')) text-gray-800 dark:text-gray-100 @endif"
          href="{{ route('moderator.ticket.blacklist') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
            </path>
          </svg>
          <span class="ml-4">{{ __('Ticket Blacklist') }}</span>
        </a>
      </li>
    @endif

    @if (Auth::user()->role == 'admin')
      <li class="relative px-6 py-1">
        <span class="text-sm font-bold">{{ __('Administration') }}</span>
      </li>
      <li class="relative px-6 py-3">
        @if (Request::routeIs('admin.overview.*'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.overview.*')) text-gray-800 dark:text-gray-100 @endif"
          href="{{ route('admin.overview.index') }}">
          <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
            <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
          </svg>
          <span class="ml-4">{{ __('Overview') }}</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        @if (Request::routeIs('admin.settings.*'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.settings.*')) text-gray-800 dark:text-gray-100 @endif"
          href="{{ route('admin.settings.index') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
            </path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <span class="ml-4">{{ __('Settings') }}</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        @if (Request::routeIs('admin.api.*'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.api.*')) text-gray-800 dark:text-gray-100 @endif"
          href="{{ route('admin.api.index') }}">
          <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path
              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
            </path>
          </svg>
          <span class="ml-4">{{ __('Application API') }}</span>
        </a>
      </li>
      <li class="relative px-6 py-3">

        <button
          class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          @click="toggleManagementMenu" aria-haspopup="true">
          <span class="inline-flex items-center">
            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
              <path
                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
              </path>
            </svg>
            <span class="ml-4">{{ __('Management') }}</span>
          </span>
          <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
        <ul x-cloak x-cloak x-show="isManagementMenuOpen" x-transition:enter="transition-all ease-in-out duration-300"
          x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-[59rem]"
          x-transition:leave="transition-all ease-in-out duration-300"
          x-transition:leave-start="opacity-100 max-h-[59rem]" x-transition:leave-end="opacity-0 max-h-0"
          class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
          aria-label="submenu">
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.users.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block" href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
          </li>
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.servers.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block" href="{{ route('admin.servers.index') }}">
              {{ __('Servers') }}
            </a>
          </li>
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.products.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block" href="{{ route('admin.products.index') }}">
              {{ __('Products') }}
            </a>
          </li>
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.store.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block" href="{{ route('admin.store.index') }}">{{ __('Store') }}</a>
          </li>
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.vouchers.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block" href="{{ route('admin.vouchers.index') }}">{{ __('Vouchers') }}</a>
          </li>
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.partners.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block" href="{{ route('admin.partners.index') }}">{{ __('Partners') }}</a>
          </li>
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.usefullinks.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block"
              href="{{ route('admin.usefullinks.index') }}">{{ __('Useful Links') }}</a>
          </li>
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.legal.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block" href="{{ route('admin.legal.index') }}">{{ __('Legal Sites') }}</a>
          </li>
        </ul>
      </li>
      <li class="relative px-6 py-3">

        <button
          class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
          @click="toggleLogsMenu" aria-haspopup="true">
          <span class="inline-flex items-center">
            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            <span class="ml-4">{{ __('Logs') }}</span>
          </span>
          <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
        <ul x-cloak x-show="isLogsMenuOpen" x-transition:enter="transition-all ease-in-out duration-300"
          x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-[59rem]"
          x-transition:leave="transition-all ease-in-out duration-300"
          x-transition:leave-start="opacity-100 max-h-[59rem]" x-transition:leave-end="opacity-0 max-h-0"
          class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
          aria-label="submenu">
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.payments.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block" href="{{ route('admin.payments.index') }}">{{ __('Payments') }}</a>
          </li>
          <li
            class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 @if (Request::routeIs('admin.activitylogs.*')) text-gray-800 dark:text-gray-100 @endif">
            <a class="w-full inline-block" href="{{ route('admin.activitylogs.index') }}">
              {{ __('Activity Logs') }}
            </a>
          </li>
        </ul>
      </li>
    @endif
  </ul>
</div>
