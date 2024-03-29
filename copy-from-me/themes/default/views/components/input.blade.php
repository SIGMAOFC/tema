@props(['disabled' => false, 'name' => '', 'type' => 'text', 'checked' => false])

@switch($type)
  @case('text')

    @default
      <input type="{{ $type }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }}
        @error($name) {!! $attributes->merge([
            'class' =>
                'border-red-600 block w-full mt-1 text-sm dark:bg-gray-700 focus:border-red-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-red rounded-md shadow-sm focus:ring focus:ring-red-200 focus:ring-opacity-50',
        ]) !!}
        @else
    {!! $attributes->merge([
        'class' =>
            'block w-full text-sm dark:border-gray-600 mt-1 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50',
    ]) !!} @enderror>
    @break

    @case('checkbox')
      <input @if ($checked) checked @endif type="{{ $type }}" name="{{ $name }}"
        {{ $disabled ? 'disabled' : '' }}
        @error($name) {!! $attributes->merge([
            'class' =>
                'text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded ml-4',
        ]) !!}
    @else
        {!! $attributes->merge([
            'class' =>
                'text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded',
        ]) !!} @enderror>
    @break

    @case('ratio')
      <input type="ratio" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }}
        @error($name) {!! $attributes->merge([
            'class' =>
                'text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray',
        ]) !!}
    @else
        {!! $attributes->merge([
            'class' =>
                'text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray',
        ]) !!} @enderror>
    @break
  @endswitch
