@props(['value', 'title', 'text' => ''])

<label {{ $attributes->merge(['class' => 'block mb-4 font-medium text-sm text-gray-700']) }}>
  <span class="text-gray-700 dark:text-gray-400">
    {{ __($title) }}
  </span>
  {{ $value ?? $slot }}
  <span class="text-xs text-gray-600 dark:text-gray-400/60">
    {{ $text }}
  </span>
</label>
