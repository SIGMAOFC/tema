@extends('layouts.main')

@section('content')
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      {{ __('Admin Overview') }}
    </h2>
    <!-- Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
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
            {{ $counters['servers']->active }}/{{ $counters['servers']->total }}
          </p>
        </div>
      </div>
      <!-- Card -->
      <div class="flex items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
            </path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ __('Users') }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ $counters['users'] }}
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
            {{ __('Total') }} {{ CREDITS_DISPLAY_NAME }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ $counters['credits'] }}
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
            {{ __('Payments') }}
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ $counters['payments']->total }}
          </p>
        </div>
      </div>
      <!-- Card -->

    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-3 grid-cols-1">

      <div class="w-full overflow-hidden col-span-2 md:col-span-1">
        <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
          {{ __('Controlpanel.gg') }}
        </h2>

        <div class="flex flex-col p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">

          <div class="mb-2">
            <a class="underline text-gray-700 dark:text-gray-200 font-semibold" target="__blank"
              href="https://discord.gg/4Y6HjD2uyU">
              {{ __('Support Server') }}
            </a>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              {{ __('Join Our Support server on discord!') }}
            </p>
          </div>
          <div class="mb-2">
            <a class="underline text-gray-700 dark:text-gray-200 font-semibold" target="__blank"
              href="https://ctrlpanel.gg/docs/intro">
              {{ __('Documentation') }}
            </a>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              {{ __('Official Controlpanel.gg Documentation') }}
            </p>
          </div>
          <div class="mb-2">
            <a class="underline text-gray-700 dark:text-gray-200 font-semibold" target="__blank"
              href="https://github.com/ControlPanel-gg/dashboard">
              {{ __('Github') }}
            </a>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              {{ __('Github of Controlpanel.gg project! Its open-source!') }}
            </p>
          </div>
          <div class="mb-2">
            <a class="underline text-gray-700 dark:text-gray-200 font-semibold" target="__blank"
              href="https://ctrlpanel.gg/docs/Contributing/donating">
              {{ __('Donate') }}
            </a>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              {{ __('Help Controlpanel.gg by Donating ❤️') }}
            </p>
          </div>
          <div class="">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
              {{ __('Version') }} - [{{ config('app')['version'] }} - {{ trim(config('BRANCHNAME')) }}]
            </p>
          </div>
        </div>
      </div>
      <div class="w-full overflow-hidden col-span-2">
        <div class="mb-4 flex justify-between ">

          <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Pterodactyl') }}
          </h2><a href="{{ route('admin.overview.sync') }}"
            class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">{{ __('Sync') }}</a>
        </div>
        @if ($deletedNodesPresent)
          <x-alert type="warning" title="Warning! Some nodes got deleted on pterodactyl only.">
            {{ __('Please click the sync button above.') }}
          </x-alert>
        @endif
        <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">{{ __('Resources') }}</th>
                <th class="px-4 py-3">{{ __('Count') }}</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Locations') }}
                    </p>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ $counters['locations'] }}
                </td>
              <tr>
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Nodes') }}
                    </p>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ $nodes->count() }}
                </td>
              </tr>
              <tr>
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Nests') }}
                    </p>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ $counters['nests'] }}
                </td>
              </tr>
              <tr>
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <p class="font-semibold">
                      {{ __('Eggs') }}
                    </p>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm">
                  {{ $counters['eggs'] }}
                </td>
              </tr>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
      <div class="w-full overflow-hidden col-span-2 md:col-span-1">
        <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
          {{ __('Latest Tickets') }}
        </h2>
        <div class="w-full overflow-x-auto rounded-lg">
          @if (!$tickets->count())
            <span style="font-size: 16px; font-weight:700">{{ __('There are no tickets') }}.</span>
          @else
            <table class="w-full whitespace-no-wrap">
              <thead>
                <tr
                  class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                  <th class="px-4 py-3">{{ __('Title') }}</th>
                  <th class="px-4 py-3">{{ __('User') }}</th>
                  <th class="px-4 py-3">{{ __('Status') }}</th>
                  <th class="px-4 py-3">{{ __('Last Updated') }}</th>

                </tr>
              </thead>
              <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @foreach ($tickets as $ticket_id => $ticket)
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm text-purple-600 underline">
                      <a class=""
                        href="{{ route('moderator.ticket.show', ['ticket_id' => $ticket_id]) }}">{{ $ticket->title }}</a>
                    </td>
                    <td class="px-4 py-3 text-sm text-purple-600 underline">
                      <a href="{{ route('admin.users.show', $ticket->user_id) }}">{{ $ticket->user }}</a>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      <span
                        class="px-2 py-1 text-xs font-semibold leading-tight rounded-full {{ $ticket->statusBadgeColor }}">{{ $ticket->status }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ $ticket->last_updated }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>
      <div class="w-full overflow-hidden col-span-2">
        <div class="mb-4 flex justify-between ">

          <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Nodes') }}
          </h2>
        </div>
        @if ($perPageLimit)
          <x-alert type="danger"
            title="Error! You reached the Pterodactyl perPage limit. Please make sure to set it higher than your server count.">
            {{ __('You can do that in settings.') }}<br>
            {{ __('Note') }}:
            {{ __('If this error persists even after changing the limit, it might mean a server was deleted on Pterodactyl, but not on ControlPanel.') }}
          </x-alert>
        @endif
        <div class="w-full overflow-x-auto rounded-lg ">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">{{ __('ID') }}</th>
                <th class="px-4 py-3">{{ __('Node') }}</th>
                <th class="px-4 py-3">{{ __('Servers') }}</th>
                <th class="px-4 py-3">{{ __('Resource Usage') }}</th>
                <th class="px-4 py-3">{{ CREDITS_DISPLAY_NAME . ' ' . __('Usage') }}</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              @foreach ($nodes as $nodeID => $node)
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3 text-sm">{{ $nodeID }}</td>
                  <td class="px-4 py-3 text-sm">{{ $node->name }}</td>
                  <td class="px-4 py-3 text-sm">{{ $node->activeServers }}/{{ $node->totalServers }}
                  </td>
                  <td class="px-4 py-3 text-sm">{{ $node->usagePercent }}%</td>
                  <td class="px-4 py-3 text-sm">{{ $node->activeEarnings }}/{{ $node->totalEarnings }}
                  </td>
                <tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="w-full overflow-hidden">
      <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
        {{ __('Latest Payments') }}
      </h2>
      <div class="grid md:grid-cols-2 gap-4">
        <x-card title="Last Month">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                <th class="px-4 py-3">{{ __('Currency') }}</th>
                <th class="px-4 py-3">{{ __('Number of Payments') }}</th>
                <th class="px-4 py-3">{{ __('Total Income') }}</th>

              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              @if (!$counters['payments']['lastMonth']->count())
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3 text-sm" colspan="3">
                    {{ __('No payments made last month.') }}
                  </td>
                </tr>
              @else
                @foreach ($counters['payments']['lastMonth'] as $currency => $income)
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">
                      {{ $currency }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ $income->count }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ $income->total }}
                    </td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </x-card>
        <x-card title="This Month">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                <th class="px-4 py-3">{{ __('Currency') }}</th>
                <th class="px-4 py-3">{{ __('Number of Payments') }}</th>
                <th class="px-4 py-3">{{ __('Total Income') }}</th>

              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              @if (!$counters['payments']['lastMonth']->count())
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3 text-sm" colspan="3">
                    {{ __('No payments made this month.') }}
                  </td>
                </tr>
              @else
                @foreach ($counters['payments']['thisMonth'] as $currency => $income)
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">
                      {{ $currency }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ $income->count }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ $income->total }}
                    </td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </x-card>
      </div>
    </div>
  </div>
@endsection
