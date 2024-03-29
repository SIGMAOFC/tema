@extends('layouts.main')

@section('content')
  <div class="container px-6 mx-auto grid">

    <div class="mb-4 flex justify-between py-6">

      <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
        {{ __('All Notifications') }}
      </h2>
      <a href="{{ route('notifications.readAll') }}"
        class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md focus:shadow-outline-purple
         active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple  focus:outline-none">{{ __('Mark all as Read') }}</a>
    </div>

    <div class="mb-8">
      @foreach ($notifications as $notification)
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800 mb-4 flex items-center  justify-between">
          <h4 class="font-semibold text-gray-600 dark:text-gray-300">
            <a class="{{ $notification->read() ? 'text-purple-600' : 'dark:text-purple-700 text-purple-500' }}"
              href="{{ route('notifications.show', $notification->id) }}">{{ $notification->data['title'] }}</a>
          </h4>
          <span
            class=" font-bold text-xs text-gray-500 dark:text-gray-600">{{ $notification->created_at->diffForHumans() }}</span>
        </div>
      @endforeach
    </div>


    {!! $notifications->links('pagination::tailwind') !!}

  </div>
@endsection
