@props(['title', 'type' => 'warn', 'class' => ''])


@php
  switch ($type) {
      case 'success':
          $color_scheme = 'text-green-700 bg-green-100 dark:bg-green-500/20 dark:text-green-500';
          $sr_text = 'Success';
          break;
      case 'info':
      default:
          $color_scheme = 'text-purple-700 bg-purple-100 dark:bg-purple-500/20 dark:text-purple-500';
          $sr_text = 'Information';
          break;
      case 'warn':
          $color_scheme = 'text-yellow-700 bg-yellow-100 dark:bg-yellow-500/20 dark:text-yellow-500';
          $sr_text = 'Warning';
          break;
      case 'danger':
          $color_scheme = 'text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-500';
          $sr_text = 'Danger';
          break;
  }
@endphp

<div
  {{ $attributes->class([$class, 'flex p-4 m-6 text-sm rounded-lg', $color_scheme, 'mt-0' => !str_contains($class, 'mt-')]) }}
  role="alert">
  <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"
    xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd"
      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
      clip-rule="evenodd"></path>
  </svg>
  <span class="sr-only">{{ $sr_text }}</span>
  <div>
    <span class="font-medium">{{ __($title) }} </span>
    {{-- <p> --}}
    {{ $slot }}
    {{-- </p> --}}
  </div>
</div>
