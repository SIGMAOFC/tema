@props(['title' => '', 'no_top_padding' => false])
<div>


  @if ($title)
    <h4 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
      {{ $title }}
    </h4>
  @endif
  <div {!! $attributes->class([
      'mb-6 items-center p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800',
      'pt-0' => $no_top_padding,
  ]) !!}>
    {{ $slot }}
  </div>

</div>
