@extends('layouts.main')

@section('content')
  <x-container title="Notification">

    <div class="mb-4 flex justify-between">

      <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
        {{ $notification->data['title'] }}
      </h2>
      <span
        class="font-bold text-xs text-gray-500 dark:text-gray-600">{{ $notification->created_at->diffForHumans() }}</span>
    </div>

    <x-card>

      {!! $notification->data['content'] !!}
    </x-card>


  </x-container>
  <!-- END CONTENT -->
@endsection
