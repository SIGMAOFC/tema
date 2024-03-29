@props(['title', 'btnLink' => '', 'btnText' => ''])

<div class="container px-6 mx-auto grid">
  <div class="flex justify-between py-6">
    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
      {{ __($title) }}
    </h2>
    @if ($btnLink && $btnText)
      <a class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md focus:shadow-outline-purple active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple focus:outline-none"
        href="{{ $btnLink }}">{{ __($btnText) }}</a>
    @endif
  </div>
  {{ $slot }}
</div>
