@extends('layouts.main')

@section('content')
  <div class="container px-6 mx-auto grid" x-data="{ server_id: null }">

    <div class="mb-4 flex justify-between py-6">

      <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
        {{ __('Servers') }}
      </h2>
      <button @if (Auth::user()->Servers->count() >= Auth::user()->server_limit) disabled="disabled" title="Server limit reached!" @endif
        href="{{ route('servers.create') }}"
        class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md focus:shadow-outline-purple
            @if (Auth::user()->Servers->count() >= Auth::user()->server_limit) opacity-50 cursor-not-allowed
            @else active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple @endif focus:outline-none"
        onclick="window.location.href = '{{ route('servers.create') }}'">{{ __('Create Server') }}</button>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3">
      @forelse ($servers as $server)
        @if ($server->location && $server->node && $server->nest && $server->egg)
          <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800 max-w-[400px]">
            <h2 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
              {{ $server->name }}
            </h2>
            <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
              <table class="w-full whitespace-no-wrap">
                <thead>
                  <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">{{ __('Resources') }}</th>
                    <th class="px-4 py-3">{{ __('Details') }}</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">
                      <div class="flex items-center text-sm">
                        <p class="font-semibold">
                          {{ __('Location') }}
                        </p>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ $server->location }}
                    </td>
                  <tr>
                    <td class="px-4 py-3">
                      <div class="flex items-center text-sm">
                        <p class="font-semibold">
                          {{ __('Node') }}
                        </p>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ $server->node }}
                    </td>
                  </tr>
                  <tr>
                    <td class="px-4 py-3">
                      <div class="flex items-center text-sm">
                        <p class="font-semibold">
                          {{ __('Status') }}
                        </p>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      @if ($server->isSuspended())
                        <span
                          class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-yellow-700 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-500">
                          {{ __('Suspended') }}
                        </span>
                      @else
                        <span
                          class="px-2 py-1 text-xs font-semibold leading-tight rounded-full text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500">
                          {{ __('Active') }}
                        </span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td class="px-4 py-3">
                      <div class="flex items-center text-sm">
                        <p class="font-semibold">
                          {{ __('Software') }}
                        </p>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ $server->nest }}, {{ $server->egg }}
                    </td>
                  </tr>
                  <tr>
                    <td class="px-4 py-3">
                      <div class="flex items-center text-sm">
                        <p class="font-semibold">
                          {{ __('Resource plan') }}
                        </p>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-sm flex items-center">
                      {{ $server->product->name }}

                      <span data-html="true"
                        data-content="{{ __('CPU') }}: {{ $server->product->cpu / 100 }} {{ __('vCores') }} <br />
                        {{ __('RAM') }}: {{ $server->product->memory }} MB <br />
                        {{ __('Disk') }}: {{ $server->product->disk }} MB <br />
                        {{ __('Backups') }}: {{ $server->product->backups }} <br />
                         {{ __('MySQL Databases') }}: {{ $server->product->databases }} <br />
                         {{ __('Allocations') }}: {{ $server->product->allocations }}"
                        data-toggle="popover" data-trigger="hover" data-placement="top">
                        <iconify-icon icon="ph:info-bold" width="20" height="20" class="ml-1 mt-1" />
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-4 py-3">
                      <div class="flex items-center text-sm">
                        <p class="font-semibold">
                          {{ __('Price') }}
                          <span
                            class="font-normal dark:text-gray-400/75 text-gray-600">({{ CREDITS_DISPLAY_NAME }})</span>
                        </p>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ $server->product->getHourlyPrice() * 24 * 30 }}
                      <span class="font-normal dark:text-gray-400/75 text-gray-600">({{ __('per Month') }})</span><br>
                      {{ number_format($server->product->getHourlyPrice(), 2, '.', '') }}
                      <span class="font-normal dark:text-gray-400/75 text-gray-600">({{ __('per Hour') }})</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mt-4 flex justify-evenly gap-4">
              <a href="{{ config('SETTINGS::SYSTEM:PTERODACTYL:URL') }}/server/{{ $server->identifier }}"
                target="__blank"
                class="w-full flex items-center justify-center px-4 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 border-purple-600 border-2 rounded-lg active:bg-purple-600 hover:bg-purple-600 text-center focus:outline-none focus:shadow-outline-purple">
                {{ __('Manage') }}
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25">
                  </path>
                </svg>
              </a>
              <a href="{{ route('servers.show', ['server' => $server->id]) }}"
                class="w-full px-4 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 border-purple-600 border-2 rounded-lg active:bg-purple-600 hover:bg-purple-600 text-center focus:outline-none focus:shadow-outline-purple">
                {{ __('Settings') }}
              </a>
            </div>
          </div>
        @endif
      @empty
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
          <h4 class="font-semibold text-gray-600 dark:text-gray-300">
            No Servers Found!
          </h4>
        </div>
      @endforelse
    </div>

  </div>
@endsection
