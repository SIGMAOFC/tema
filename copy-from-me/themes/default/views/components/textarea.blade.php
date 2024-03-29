@props(['disabled' => false, 'name' => '', 'text' => ''])

<textarea name="{{ $name }}" {{ $disabled ? 'disabled' : '' }}
  @error($name) {!! $attributes->merge([
      'class' =>
          'border-red-600 block w-full mt-1 text-sm dark:bg-gray-700 focus:border-red-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-red rounded-md shadow-sm focus:ring focus:ring-red-200 focus:ring-opacity-50',
  ]) !!}
    @else
    {!! $attributes->merge([
        'class' =>
            'block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50',
    ]) !!} @enderror>
    {{ $slot }}
</textarea>
<span class="text-xs text-gray-600 dark:text-gray-400">
  {{ $text }}
</span>
