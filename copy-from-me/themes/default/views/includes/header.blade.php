<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
  <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
    <!-- Mobile hamburger -->
    <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
      @click="toggleSideMenu" aria-label="Menu">
      <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
          d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
          clip-rule="evenodd"></path>
      </svg>
    </button>

    <div class="sm:flex items-center gap-6 hidden">
      @foreach ($useful_links as $link)
        <div class="flex items-center gap-1 dark:text-gray-300 text-gray-600">
          <iconify-icon icon="{{ $link->icon }}" height="16" width="16" class="mr-1"></iconify-icon>
          <a href="{{ $link->link }}" class="underline" target="__blank">
            {{ $link->title }}</a>
        </div>
      @endforeach
    </div>
    <!-- Search input -->
    <div class="flex justify-center flex-1 lg:mr-32">
      <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
        {{-- <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for projects" aria-label="Search" /> --}}

      </div>
    </div>
    <ul class="flex items-center flex-shrink-0 space-x-6">
      <!-- Theme toggler -->
      <li class="flex">
        <button class="rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleTheme"
          aria-label="Toggle color mode">
          <template x-if="!dark">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
              <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
          </template>
          <template x-if="dark">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                clip-rule="evenodd"></path>
            </svg>
          </template>
        </button>
      </li>
      <!-- Notifications menu -->
      <li class="relative">
        <button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"
          @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu" aria-label="Notifications"
          aria-haspopup="true">
          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
            </path>
          </svg>
          <!-- Notification badge -->
          @if (Auth::user()->unreadNotifications->count() != 0)
            <span aria-hidden="true"
              class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"></span>
          @endif
        </button>
        <ul x-cloak x-show="isNotificationsMenuOpen" x-transition:leave="transition ease-in duration-150"
          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeNotificationsMenu"
          @keydown.escape="closeNotificationsMenu"
          class="absolute right-0 w-80 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700">
          @foreach (Auth::user()->unreadNotifications->sortBy('created_at')->take(5) as $notification)
            <li class="flex">
              <a class="dark:hover:bg-gray-800 dark:hover:text-gray-200 duration-150 font-semibold hover:bg-gray-100 hover:text-gray-800 inline-flex justify-between px-2 py-1 rounded-md text-sm transition-colors w-full"
                href="{{ route('notifications.show', $notification->id) }}">
                <span>{{ $notification->data['title'] }}</span>
                <span
                  class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-gray-600 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-600">
                  {{ $notification->created_at->longAbsoluteDiffForHumans() }}
                  ago
                </span>
              </a>
            </li>
          @endforeach
          <li class="flex">
            <a class="dark:hover:bg-gray-800 dark:hover:text-gray-200 duration-150 font-semibold hover:bg-gray-100 hover:text-gray-800 inline-flex justify-between px-2 py-1 rounded-md text-sm transition-colors w-full"
              href="{{ route('notifications.index') }}">
              <span>{{ __('See all Notifications') }}</span>
            </a>
          </li>
          <li class="flex">
            <a class="dark:hover:bg-gray-800 dark:hover:text-gray-200 duration-150 font-semibold hover:bg-gray-100 hover:text-gray-800 inline-flex justify-between px-2 py-1 rounded-md text-sm transition-colors w-full"
              href="{{ route('notifications.readAll') }}">
              <span>{{ __('Mark all as read') }}</span>

            </a>
          </li>

        </ul>
      </li>
      <!-- Language Selection -->
      @if (config('SETTINGS::LOCALE:CLIENTS_CAN_CHANGE') == 'true')
        <li class="relative">
          <button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"
            @click="toggleLanguageMenu" @keydown.escape="closeLanguageMenu" aria-label="Language" aria-haspopup="true">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 48 48">
              <path d="M0 0h48v48h-48z" fill="none" />
              <path
                d="M23.99 4c-11.05 0-19.99 8.95-19.99 20s8.94 20 19.99 20c11.05 0 20.01-8.95 20.01-20s-8.96-20-20.01-20zm13.85 12h-5.9c-.65-2.5-1.56-4.9-2.76-7.12 3.68 1.26 6.74 3.81 8.66 7.12zm-13.84-7.93c1.67 2.4 2.97 5.07 3.82 7.93h-7.64c.85-2.86 2.15-5.53 3.82-7.93zm-15.48 19.93c-.33-1.28-.52-2.62-.52-4s.19-2.72.52-4h6.75c-.16 1.31-.27 2.64-.27 4 0 1.36.11 2.69.28 4h-6.76zm1.63 4h5.9c.65 2.5 1.56 4.9 2.76 7.13-3.68-1.26-6.74-3.82-8.66-7.13zm5.9-16h-5.9c1.92-3.31 4.98-5.87 8.66-7.13-1.2 2.23-2.11 4.63-2.76 7.13zm7.95 23.93c-1.66-2.4-2.96-5.07-3.82-7.93h7.64c-.86 2.86-2.16 5.53-3.82 7.93zm4.68-11.93h-9.36c-.19-1.31-.32-2.64-.32-4 0-1.36.13-2.69.32-4h9.36c.19 1.31.32 2.64.32 4 0 1.36-.13 2.69-.32 4zm.51 11.12c1.2-2.23 2.11-4.62 2.76-7.12h5.9c-1.93 3.31-4.99 5.86-8.66 7.12zm3.53-11.12c.16-1.31.28-2.64.28-4 0-1.36-.11-2.69-.28-4h6.75c.33 1.28.53 2.62.53 4s-.19 2.72-.53 4h-6.75z" />
            </svg>
          </button>
          <ul x-cloak x-show="isLanguageMenuOpen" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeLanguageMenu"
            @keydown.escape="closeLanguageMenu"
            class="absolute right-0 w-80 max-h-96 overflow-y-auto p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700">
            <form method="post" action="{{ route('changeLocale') }}" class="nav-item text-center">
              @csrf
              @foreach (explode(',', config('SETTINGS::LOCALE:AVAILABLE')) as $key)
                <li class="flex">
                  <button
                    class="dark:hover:bg-gray-800 dark:hover:text-gray-200 duration-150 font-semibold hover:bg-gray-100 hover:text-gray-800 inline-flex justify-between px-2 py-1 rounded-md text-sm transition-colors w-full"
                    name="inputLocale" value="{{ $key }}">
                    {{ __($key) }}
                  </button>
                </li>
              @endforeach
            </form>
          </ul>
        </li>
      @endif
      <!-- Profile menu -->
      <li class="relative">
        <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
          @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account" aria-haspopup="true">
          <img class="object-cover w-8 h-8 rounded-full" src="{{ Auth::user()->getAvatar() }}"
            alt="{{ Auth::user()->name }}'s Avatar" aria-hidden="true" loading="lazy" />
        </button>
        <ul x-cloak x-show="isProfileMenuOpen" x-transition:leave="transition ease-in duration-150"
          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeProfileMenu"
          @keydown.escape="closeProfileMenu"
          class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
          aria-label="submenu">
          <li class="flex">
            <p
              class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
              <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span>{{ config('SETTINGS::SYSTEM:CREDITS_DISPLAY_NAME') }}:
                {{ Auth::user()->credits() }}</span>
            </p>
          </li>

          <li class="flex">
            <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
              href="{{ route('profile.index') }}">
              <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <span>{{ __('Profile') }}</span>
            </a>
          </li>

          <li class="flex">
            <button
              class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
              @click="openRedeemModal">
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122">
                </path>
              </svg>
              <span>{{ __('Redeem Code') }}</span>
            </button>
          </li>

          @if (session()->get('previousUser'))
            <li class="flex">
              <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                href="{{ route('users.logbackin') }}">
                <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                  <path
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                  </path>
                  <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>{{ __('Log back in') }}</span>
              </a>
            </li>
          @endif
          <li class="flex">
            <!-- Authentication -->

            <form method="POST" class="flex w-full" id="logout-form" action="{{ route('logout') }}">
              @csrf
              <button
                class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                onclick="document.getElementById('logout-form').submit()">
                <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                  <path
                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                  </path>
                </svg>
                <span>Log out</span>

              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</header>
