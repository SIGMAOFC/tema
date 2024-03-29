@extends('layouts.main')
@section('content')
  <div class="container px-6 mx-auto grid" x-data="{ tab: 0 }">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      {{ __('Settings') }}
    </h2>
    @if (!file_exists(base_path() . '/install.lock'))
      <div class="p-4 mb-4 text-sm bg-red-600 text-red-100 rounded-lg dark:bg-red-200 dark:text-red-800">
        <h4>{{ __('The installer is not locked!') }}</h4>
        <p>
          {{ __('please create a file called "install.lock" in your dashboard Root directory. Otherwise no settings will be loaded!') }}
        </p>
        <a href="/install?step=7"><button class="btn btn-outline-danger">{{ __('or click here') }}</button></a>
      </div>
    @endif

    <div
      class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
      <ul class="flex flex-wrap -mb-px">
        @foreach ($tabListItems as $tabListItem)
          <li class="mr-2" x-init="if (window.location.hash == '#' + '{{ str_replace(' ', '-', $tabListItem) }}'.toLowerCase()) tab = {{ $loop->index }}">
            <button
              @click="tab = {{ $loop->index }}; window.location.hash = '{{ str_replace(' ', '-', $tabListItem) }}'.toLowerCase()"
              :class="tab == {{ $loop->index }} ?
                  'border-purple-600 text-purple-600 dark:border-purple-500 dark:text-purple-500' :
                  'text-gray-500 hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
              class="inline-block p-4 rounded-t-lg border-b-2 border-transparent ">
              {!! $tabListItem !!}
            </button>
          </li>
        @endforeach
      </ul>
    </div>

    @foreach ($tabs as $tab)
      <div x-cloak x-show="tab == {{ $loop->index }}">
        @include($tab)
      </div>
    @endforeach

  </div>
@endsection
