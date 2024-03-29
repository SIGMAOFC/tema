@extends('layouts.main')

@section('content')
  <x-container title="Activity Logs">

    @if ($cronlogs)
      <x-alert title="Cron Jobs are running!" type="success">{{ $cronlogs }}</x-alert>
    @else
      <x-alert title="No recent activity from cronjobs!" type="danger">{{ __('Are cronjobs running?') }}
        <br /><a class="text-primary underline" target="_blank"
          href="https://ctrlpanel.gg/docs/Installation/getting-started#crontab-configuration">{{ __('Check the docs for it here') }}</a>
      </x-alert>
    @endif

    <form method="get" action="{{ route('admin.activitylogs.index') }}">
      @csrf
      <x-label title="Search Logs Form User">
        <x-input value="{{ \Request::get('search') }}" name="search" placeholder="" type="text" autofocus>
          <x-button>{{ __('Search') }}</x-button>
        </x-input>
      </x-label>

    </form>

    <div class="w-full overflow-x-auto rounded-lg shadow-md ">
      <table class="w-full -no-wrap">
        <thead>
          <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="px-4 py-3">{{ __('Causer') }}</th>
            <th class="px-4 whitespacepy-3">{{ __('Log') }}</th>
            <th class="px-4 py-3">{{ __('Action') }}</th>
            <th class="px-4 py-3">{{ __('Time') }}</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          @foreach ($logs as $log)
            <tr class="text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">
                <div class="flex items-center text-sm">
                  <p class="font-semibold">
                    @if ($log->causer)
                      <a href='/admin/users/{{ $log->causer_id }}'>
                        {{ json_decode($log->causer)->name }}
                      @else
                        System
                    @endif
                  </p>
                </div>
              </td>
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
                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-500/20 dark:text-green-500">
                    Created
                  </span>
                @elseif(str_starts_with($log->description, 'redeemed'))
                  <span
                    class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-500/20 dark:text-blue-500">
                    Redeemed
                  </span>
                @elseif(str_starts_with($log->description, 'deleted'))
                  <span
                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-500/20 dark:text-red-500">
                    Deleted
                  </span>
                @elseif(str_starts_with($log->description, 'gained'))
                  <span
                    class="px-2 py-1 font-semibold leading-tight text-lime-700 bg-lime-100 rounded-full dark:bg-lime-500/20 dark:text-lime-500">
                    Gained
                  </span>
                @elseif(str_starts_with($log->description, 'updated'))
                  <span
                    class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-500/20 dark:text-yellow-500">
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

    {!! $logs->links('pagination::tailwind') !!}
  </x-container>
@endsection
